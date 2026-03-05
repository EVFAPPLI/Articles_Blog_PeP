<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations Générales')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Select::make('category')
                            ->options([
                                'Esprit PEP' => 'Esprit PEP (Charge mentale, moteur humain)',
                                'Boîte à outils' => 'Boîte à outils (Logiciels, IA au quotidien)',
                                'Pilotage' => 'Pilotage (Gestion du temps, priorisation)',
                                'Leadership' => 'Leadership (Management, collaboration)',
                                'Flow' => 'Flow (Équilibre perso/pro, detox)',
                            ])
                            ->searchable()
                            ->required(),
                        
                        Forms\Components\TextInput::make('author')
                            ->default('Visibloo')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->default(now()),
                        
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publier')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Contenu et Images')
                    ->schema([
                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Image de Une')
                            ->directory('blog-covers')
                            ->image()
                            ->columnSpanFull(),
                        
                        \AmidEsfahani\FilamentTinyEditor\TinyEditor::make('vignette_content')
                            ->label('Extrait (Vignette)')
                            ->profile('default')
                            ->columnSpanFull(),
                        
                        \AmidEsfahani\FilamentTinyEditor\TinyEditor::make('html_content')
                            ->label('Contenu de l\'Article')
                            ->profile('default')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('blog-images')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Optimisation SEO')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Méta Description')
                            ->maxLength(255),
                        Forms\Components\TagsInput::make('keywords')
                            ->label('Mots-clés SEO')
                            ->separator(','),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Vignette'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => \Illuminate\Support\Str::before($state, ':'))
                    ->tooltip(fn (Post $record): string => $record->title),
                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->sortable()
                    ->badge(),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('En Ligne'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Statut'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Modifier'),
                Tables\Actions\Action::make('export_json')
                    ->label('Exporter JSON')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->iconButton()
                    ->tooltip('Exporter en JSON')
                    ->action(fn (Post $record) => response()->streamDownload(
                        fn () => print json_encode($record->toArray(), JSON_PRETTY_PRINT),
                        "article-{$record->slug}-" . now()->format('Y-m-d') . ".json"
                    )),
                Tables\Actions\Action::make('view_public')
                    ->label('Voir sur le site')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->iconButton()
                    ->tooltip('Voir sur le site public')
                    ->url(fn (Post $record): string => route('blog.show', $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Supprimer'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('import_json')
                    ->label('Importer JSON')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('primary')
                    ->form([
                        Forms\Components\FileUpload::make('json_file')
                            ->label('Fichier JSON')
                            ->required()
                            ->acceptedFileTypes(['application/json'])
                            ->disk('local')
                            ->directory('temp-imports'),
                    ])
                    ->action(function (array $data) {
                        $disk = \Illuminate\Support\Facades\Storage::disk('local');
                        
                        if (!$disk->exists($data['json_file'])) {
                            \Filament\Notifications\Notification::make()
                                ->title('Erreur')
                                ->body('Le fichier temporaire est introuvable.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $content = $disk->get($data['json_file']);
                        $articleData = json_decode($content, true);
                        
                        if (!$articleData || !isset($articleData['slug'])) {
                            \Filament\Notifications\Notification::make()
                                ->title('Erreur')
                                ->body('Fichier JSON invalide.')
                                ->danger()
                                ->send();
                            return;
                        }

                        // Nettoyer les champs que l'on ne veut pas écraser bêtement ou qui sont gérés par le système
                        $toUpdate = collect($articleData)->only([
                            'title', 'slug', 'category', 'author', 'html_content', 
                            'vignette_content', 'meta_description', 'keywords', 
                            'is_published', 'published_at'
                        ])->toArray();

                        Post::updateOrCreate(
                            ['slug' => $articleData['slug']],
                            $toUpdate
                        );

                        // Supprimer le fichier temporaire via le disque
                        $disk->delete($data['json_file']);

                        \Filament\Notifications\Notification::make()
                            ->title('Succès')
                            ->body('L\'article a été importé avec succès.')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
