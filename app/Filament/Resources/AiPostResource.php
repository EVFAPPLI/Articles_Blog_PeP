<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiPostResource\Pages;
use App\Filament\Resources\AiPostResource\RelationManagers;
use App\Models\AiPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\GeminiService;
use App\Services\ImageService;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;

class AiPostResource extends Resource
{
    protected static ?string $model = AiPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?string $navigationLabel = 'Brouillons IA';
    protected static ?string $pluralLabel = 'Brouillons IA';
    protected static ?string $modelLabel = 'Brouillon IA';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informations de Base')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre')
                            ->columnSpanFull()
                            ->required(),
                            
                        Select::make('category')
                            ->label('Catégorie')
                            ->options([
                                'Esprit PEP' => 'Esprit PEP',
                                'Boîte à outils' => 'Boîte à outils',
                                'Pilotage' => 'Pilotage',
                                'Leadership' => 'Leadership',
                                'Flow' => 'Flow',
                            ])
                            ->required(),
                    ]),

                Section::make('Laboratoire de Contenu (IA)')
                    ->schema([
                        Textarea::make('source_content')
                            ->label('Texte Source Brute (Votre brouillon)')
                            ->rows(8)
                            ->hintAction(
                                Action::make('generate_html')
                                    ->label('Générer HTML Premium')
                                    ->icon('heroicon-m-sparkles')
                                    ->color('success')
                                    ->action(function (Get $get, Set $set) {
                                        $source = $get('source_content');
                                        if (empty($source)) {
                                            Notification::make()->warning()->title('Veuillez saisir un texte source')->send();
                                            return;
                                        }
                                        $html = GeminiService::formatToHtml($source);
                                        if ($html) {
                                            $set('html_content', $html);
                                            Notification::make()->success()->title('HTML finalisé ! Vérifiez le résultat ci-dessous.')->send();
                                        } else {
                                            Notification::make()->danger()->title('Échec de la génération')->send();
                                        }
                                    })
                            ),
                            
                        RichEditor::make('html_content')
                            ->label('Résultat HTML (Modifiable)')
                            ->fileAttachmentsDirectory('blog-content')
                            ->columnSpanFull(),
                    ]),
                    
                Section::make('Vignette et Résumé')
                    ->schema([
                        RichEditor::make('vignette_content')
                            ->label('Résumé (Extrait court)')
                            ->hintAction(
                                Action::make('generate_vignette')
                                    ->label('Générer Résumé depuis le HTML')
                                    ->icon('heroicon-m-sparkles')
                                    ->color('success')
                                    ->action(function (Get $get, Set $set) {
                                        $html = $get('html_content');
                                        if (empty($html)) {
                                            Notification::make()->warning()->title('Pas de contenu HTML sur lequel se baser.')->send();
                                            return;
                                        }
                                        $vignette = GeminiService::generateVignette($html);
                                        if ($vignette) {
                                            $set('vignette_content', $vignette);
                                            Notification::make()->success()->title('Résumé généré !')->send();
                                        }
                                    })
                            )
                            ->columnSpanFull(),
                    ]),
                    
                Section::make('Laboratoire d\'Image (Imagen)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('image_prompt')
                            ->label('Prompt de l\'Image')
                            ->placeholder('Ex: Un bureau moderne avec un café chaud...')
                            ->hint('Laissez vide pour générer à partir du texte source.')
                            ->columnSpanFull(),
                            
                        Select::make('image_style')
                            ->label('Style de l\'image')
                            ->options([
                                'réaliste' => 'Photographie réaliste',
                                'graphique' => 'Illustration graphique (Vecteur)',
                                'aquarelle' => 'Peinture aquarelle',
                            ])
                            ->default('réaliste')
                            ->ignored() // Ce champ sert juste au bouton, pas besoin de le sauver en BDD s'il n'existe pas, mais on peut le garder pour l'UX
                            ->dehydrated(false), // Ne pas sauver en bdd
                            
                        FileUpload::make('cover_image')
                            ->label('Illustration de couverture')
                            ->directory('blog-covers')
                            ->image()
                            ->columnSpanFull()
                            ->hintAction(
                                Action::make('generate_image')
                                    ->label('Créer avec Imagen')
                                    ->icon('heroicon-m-sparkles')
                                    ->color('success')
                                    ->action(function (Get $get, Set $set) {
                                        $prompt = $get('image_prompt');
                                        if (empty($prompt)) {
                                            $source = $get('source_content');
                                            if (empty($source)) {
                                                Notification::make()->warning()->title('Veuillez fournir un prompt ou un texte source.')->send();
                                                return;
                                            }
                                            $prompt = strip_tags(Str::limit($source, 500));
                                        }
                                        
                                        $style = $get('image_style') ?? 'réaliste';
                                        
                                        Notification::make()->info()->title('Création de l\'image en cours (Imagen)...')->send();
                                        
                                        $base64 = GeminiService::generateImage($prompt, $style);
                                        if ($base64) {
                                            $imageService = app(ImageService::class);
                                            $prefix = "data:image/jpeg;base64,";
                                            $slug = Str::slug($get('title') ?? 'ai-post');
                                            $path = $imageService->saveBase64Image($prefix . $base64, 'blog-covers', $slug . '-cover-' . time());
                                            
                                            // Filament veut un type FileUpload compatible, généralement un string de fichier dans un tableau ou directement le string selon la config
                                            $set('cover_image', $path); 
                                            Notification::make()->success()->title('Image ajoutée avec succès !')->send();
                                        } else {
                                            Notification::make()->danger()->title('Échec de la génération')->send();
                                        }
                                    })
                            ),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Illustration')
                    ->circular(),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'warning',
                        'transferred' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Brouillon',
                        'transferred' => 'Transféré',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiPosts::route('/'),
            'create' => Pages\CreateAiPost::route('/create'),
            'edit' => Pages\EditAiPost::route('/{record}/edit'),
        ];
    }
}
