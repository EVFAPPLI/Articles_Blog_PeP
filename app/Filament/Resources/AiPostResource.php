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
use Filament\Forms\Components\Toggle;
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
                        TextInput::make('youtube_url')
                            ->label('Lien Vidéo YouTube (Optionnel)')
                            ->placeholder('Ex: https://www.youtube.com/watch?v=...')
                            ->url()
                            ->columnSpanFull(),
                            
                        Textarea::make('source_content')
                            ->label('Texte Source Brute ou Code HTML')
                            ->rows(12)
                            ->hintActions([
                                Action::make('keep_html')
                                    ->label('✅ Conserver mon HTML tel quel')
                                    ->color('gray')
                                    ->action(function (Get $get, Set $set) {
                                        $source = $get('source_content');
                                        if (empty($source)) {
                                            Notification::make()->warning()->title('Veuillez saisir un contenu')->send();
                                            return;
                                        }
                                        $set('html_content', $source);
                                        Notification::make()->success()->title('HTML validé tel quel !')->send();
                                    }),
                                Action::make('generate_html')
                                    ->label('✨ Sublimer le texte brut avec l\'IA')
                                    ->icon('heroicon-m-sparkles')
                                    ->color('success')
                                    ->action(function (Get $get, Set $set) {
                                        $source = $get('source_content');
                                        if (empty($source)) {
                                            Notification::make()->warning()->title('Veuillez saisir un texte source')->send();
                                            return;
                                        }
                                        Notification::make()->info()->title('Magie IA en cours...')->send();
                                        
                                        $youtubeUrl = $get('youtube_url');
                                        $html = GeminiService::formatToHtml($source, $youtubeUrl);
                                        
                                        if ($html) {
                                            $set('html_content', $html);
                                            Notification::make()->success()->title('Design ultra-moderne appliqué !')->send();
                                        } else {
                                            Notification::make()->danger()->title('Échec de la génération')->send();
                                        }
                                    }),
                            ]),
                            
                        \Filament\Forms\Components\Hidden::make('html_content'),
                        
                        \Filament\Forms\Components\Placeholder::make('html_preview')
                            ->label('Aperçu du Rendu Final (Magie IA)')
                            ->content(fn (Get $get) => new \Illuminate\Support\HtmlString('<div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden" style="min-height: 200px;">' . ($get('html_content') ?? '<p class="text-gray-400 italic text-center mt-10">Aucun rendu pour le moment.</p>') . '</div>'))
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
                                'futuriste' => 'Moderne / Futuriste',
                            ])
                            ->default('réaliste')
                            ->dehydrated(false), // Ne pas sauver en bdd
                            
                        Toggle::make('image_with_text')
                            ->label('Autoriser le texte sur l\'image')
                            ->helperText('Si désactivé, l\'IA a pour consigne stricte de ne mettre aucun texte.')
                            ->default(false)
                            ->dehydrated(false),
                            
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
                                            $title = $get('title') ?? 'Article de blog';
                                            $category = $get('category') ?? 'Thème général';
                                            $prompt = "Un visuel conceptuel et créatif illustrant l'article de blog suivant : '$title', de la catégorie '$category'.";
                                        }
                                        
                                        $style = $get('image_style') ?? 'réaliste';
                                        $withText = $get('image_with_text') ?? false;
                                        
                                        Notification::make()->info()->title('Création de l\'image en cours (Imagen)...')->send();
                                        
                                        $base64 = GeminiService::generateImage($prompt, $style, $withText);
                                        // $base64 peut contenir "ERROR: ..."
                                        if ($base64 && !str_starts_with($base64, 'ERROR:')) {
                                            $imageService = app(ImageService::class);
                                            $prefix = "data:image/jpeg;base64,";
                                            $slug = Str::slug($get('title') ?? 'ai-post');
                                            $path = $imageService->saveBase64Image($prefix . $base64, 'blog-covers', $slug . '-cover-' . time());
                                            
                                            $set('cover_image', [$path => $path]); // FileUpload attend un tableau en interne
                                            
                                            Notification::make()->success()->title('Image générée avec succès !')->send();
                                        } else {
                                            $errorMsg = str_replace('ERROR: ', '', $base64 ?? 'Erreur inconnue');
                                            Notification::make()->danger()
                                                ->title('Échec de la génération d\'image')
                                                ->body($errorMsg)
                                                ->send();
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
                Tables\Actions\Action::make('preview')
                    ->label('Aperçu')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn ($record) => 'Aperçu : ' . $record->title)
                    ->modalWidth('7xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fermer')
                    ->form([
                        \Filament\Forms\Components\Placeholder::make('html_preview')
                            ->hiddenLabel()
                            ->content(fn ($record) => new \Illuminate\Support\HtmlString('<div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden" style="min-height: 200px; max-width: 100%;">' . ($record->html_content ?? '<p class="text-gray-400 italic text-center mt-10">Aucun rendu pour le moment.</p>') . '</div>')),
                    ]),
                Tables\Actions\Action::make('transfer_to_blog')
                    ->label(fn ($record) => $record->status === 'transferred' ? 'Mettre à jour' : 'Publier')
                    ->icon('heroicon-o-rocket-launch')
                    ->color(fn ($record) => $record->status === 'transferred' ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => $record->status === 'transferred' ? 'Mettre à jour l\'article public' : 'Publier l\'article sur le blog public')
                    ->modalDescription(fn ($record) => $record->status === 'transferred' 
                        ? 'L\'article public existant sera mis à jour avec le contenu actuel de ce brouillon.' 
                        : 'Êtes-vous sûr de vouloir publier ce brouillon ? Un nouvel article officiel sera créé.')
                    ->modalSubmitActionLabel(fn ($record) => $record->status === 'transferred' ? 'Oui, mettre à jour' : 'Oui, publier')
                    ->action(function ($record) {
                        if (empty($record->title) || empty($record->html_content)) {
                            Notification::make()->warning()->title('Impossible de publier : Titre ou HTML manquant.')->send();
                            return;
                        }

                        if ($record->post_id) {
                            $post = \App\Models\Post::find($record->post_id);
                            if ($post) {
                                $post->update([
                                    'title' => $record->title,
                                    'category' => $record->category ?? 'Non classé',
                                    'html_content' => $record->html_content,
                                    'vignette_content' => $record->vignette_content ?? '<p></p>',
                                    'cover_image' => $record->cover_image,
                                ]);
                                Notification::make()->success()->title('Article public mis à jour avec succès !')->send();
                                return;
                            }
                        }

                        // Création dans la vraie table posts
                        $post = \App\Models\Post::create([
                            'title' => $record->title,
                            'slug' => \Illuminate\Support\Str::slug($record->title) . '-' . time(),
                            'category' => $record->category ?? 'Non classé',
                            'html_content' => $record->html_content,
                            'vignette_content' => $record->vignette_content ?? '<p></p>',
                            'cover_image' => $record->cover_image,
                            'author' => 'Bruno Savoyat, PEP worldwide',
                            'is_published' => true,
                            'published_at' => now(),
                        ]);

                        // Mise a jour du statut du brouillon et sauvegarde de l'ID post
                        $record->update(['status' => 'transferred', 'post_id' => $post->id]);

                        Notification::make()->success()->title('Brouillon publié avec succès sur le blog public !')->send();
                    }),
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
