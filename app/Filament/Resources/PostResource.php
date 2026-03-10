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
use Filament\Forms\Components\Actions\Action;
use App\Services\GeminiService;

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
                            ->hintAction(
                                Action::make('generate_vignette')
                                    ->label('Générer l\'extrait-vignette par l\'IA')
                                    ->icon('heroicon-o-sparkles')
                                    ->modalHeading('Proposition d\'extrait par l\'IA')
                                    ->modalSubmitActionLabel('Accepter et Remplacer')
                                    ->form([
                                        \AmidEsfahani\FilamentTinyEditor\TinyEditor::make('suggested_vignette')
                                            ->label('Extrait proposé')
                                            ->profile('default')
                                            ->minHeight(200)
                                            ->maxHeight(300)
                                            ->required(),
                                    ])
                                    ->mountUsing(function (Forms\ComponentContainer $form, Forms\Get $get) {
                                        $source = $get('html_content');
                                        if (empty($source)) {
                                            \Filament\Notifications\Notification::make()->warning()->title('Veuillez rédiger l\'article complet d\'abord.')->send();
                                            return;
                                        }
                                        $prompt = "Rédige un court extrait très attractif et percutant (2 à 3 phrases max) résumant parfaitement cet article de blog. Ne retourne que la vignette, avec de légères balises de mise en forme HTML (comme <strong> ou <em>) si approprié.";
                                        $generated = GeminiService::generateContent($prompt, strip_tags($source));
                                        if ($generated) {
                                            $form->fill([
                                                'suggested_vignette' => preg_replace('/```html\n?(.*?)\n?```/is', '$1', $generated)
                                            ]);
                                        } else {
                                            \Filament\Notifications\Notification::make()->danger()->title('Problème avec l\'IA.')->send();
                                        }
                                    })
                                    ->action(function (Forms\Set $set, array $data) {
                                        if (!empty($data['suggested_vignette'])) {
                                            $set('vignette_content', $data['suggested_vignette']);
                                            \Filament\Notifications\Notification::make()->success()->title('Vignette remplacée avec succès !')->send();
                                        }
                                    })
                            )
                            ->profile('default')
                            ->minHeight(200)
                            ->maxHeight(300)
                            ->columnSpanFull(),
                        
                        \AmidEsfahani\FilamentTinyEditor\TinyEditor::make('html_content')
                            ->label('Contenu de l\'Article')
                            ->hintActions([
                                Action::make('auto_layout')
                                    ->label('Mise en page intelligente (SEO/GEO)')
                                    ->icon('heroicon-o-sparkles')
                                    ->color('primary')
                                    ->modalHeading('Mise en page optimisée par l\'IA')
                                    ->modalDescription('L\'IA va restructurer votre article (titres, listes, mise en forme) pour un rendu SEO/GEO Premium. LE TEXTE DE L\'AUTEUR SERA CONSERVÉ À 100%.')
                                    ->modalSubmitActionLabel('Appliquer la structure IA')
                                    ->form([
                                        \AmidEsfahani\FilamentTinyEditor\TinyEditor::make('ai_restructured_content')
                                            ->label('Aperçu de la nouvelle structure')
                                            ->profile('default')
                                            ->required(),
                                    ])
                                    ->mountUsing(function (Forms\ComponentContainer $form, Forms\Get $get) {
                                        $source = $get('html_content');
                                        if (empty($source)) {
                                            \Filament\Notifications\Notification::make()->warning()->title('Le contenu est vide.')->send();
                                            return;
                                        }

                                        $prompt = "Tu es un expert en mise en page HTML sémantique. Ton rôle est d'apporter une structure 'Premium' à cet article de blog. 
                                        CONSIGNES :
                                        1. NE TOUCHE PAS AU TEXTE ORIGINAL. Aucun mot ne doit être ajouté, supprimé ou modifié. L'intégrité du texte est sacrée.
                                        2. Ajoute des balises H2 et H3 logiques pour la hiérarchie.
                                        3. Utilise <ul>/<li> pour les listes.
                                        4. Utilise <strong> pour le relief SEO.
                                        5. Nettoie le code HTML (styles parasites, balises inutiles).
                                        6. Retourne UNIQUEMENT le code HTML propre, sans aucun texte autour ni blocs markdown.";

                                        $restructured = GeminiService::generateContent($prompt, $source);
                                        
                                        if ($restructured) {
                                            $cleaned = preg_replace('/```html\n?(.*?)\n?```/is', '$1', $restructured);
                                            $form->fill([
                                                'ai_restructured_content' => $cleaned
                                            ]);
                                        } else {
                                            \Filament\Notifications\Notification::make()->danger()->title('Problème avec l\'IA. Vérifiez les logs.')->send();
                                        }
                                    })
                                    ->action(function (Forms\Set $set, array $data) {
                                        if (!empty($data['ai_restructured_content'])) {
                                            $set('html_content', $data['ai_restructured_content']);
                                            \Filament\Notifications\Notification::make()->success()->title('Mise en page IA appliquée avec succès !')->send();
                                        }
                                    }),
                                Action::make('improve_html')
                                    ->label('Améliorer le contenu')
                                    ->icon('heroicon-o-sparkles')
                                    ->modalHeading('Proposition d\'amélioration par l\'IA')
                                    ->modalDescription('L\'IA a généré une version améliorée de votre texte. Vous pouvez la modifier avant de l\'accepter.')
                                    ->modalSubmitActionLabel('Accepter et Remplacer')
                                    ->form([
                                        \AmidEsfahani\FilamentTinyEditor\TinyEditor::make('suggested_content')
                                            ->label('Texte amélioré par Gemini')
                                            ->profile('default')
                                            ->required(),
                                    ])
                                    ->mountUsing(function (Forms\ComponentContainer $form, Forms\Get $get) {
                                        $source = $get('html_content');
                                        if (empty($source)) {
                                            \Filament\Notifications\Notification::make()->warning()->title('Le contenu est vide.')->send();
                                            return;
                                        }
                                        $prompt = "Tu es un copywriter web expert. Améliore ce texte de blog pour le rendre plus professionnel, attractif et agréable à lire. Corrige les fautes, optimise la fluidité. IMPORTANT : CONSERVE STRICTEMENT LE CODE HTML, les balises de paragraphe, liste, titre. Ne renvoie que le code HTML amélioré de l'article.";
                                        $improved = GeminiService::generateContent($prompt, $source);
                                        if ($improved) {
                                            $form->fill([
                                                'suggested_content' => preg_replace('/```html\n?(.*?)\n?```/is', '$1', $improved)
                                            ]);
                                        } else {
                                            \Filament\Notifications\Notification::make()->danger()->title('Problème avec l\'IA. Vérifiez les logs.')->send();
                                        }
                                    })
                                    ->action(function (Forms\Set $set, array $data) {
                                        if (!empty($data['suggested_content'])) {
                                            $set('html_content', $data['suggested_content']);
                                            \Filament\Notifications\Notification::make()->success()->title('Texte remplacé avec succès !')->send();
                                        }
                                    }),
                            ])
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
                            ->hintAction(
                                Action::make('generate_meta')
                                    ->label('Optimiser SEO (IA)')
                                    ->icon('heroicon-o-sparkles')
                                    ->modalHeading('Proposition de Méta Description')
                                    ->modalSubmitActionLabel('Accepter et Remplacer')
                                    ->form([
                                        Forms\Components\Textarea::make('suggested_meta')
                                            ->label('Méta Description proposée')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->mountUsing(function (Forms\ComponentContainer $form, Forms\Get $get) {
                                        $source = $get('html_content');
                                        if (empty($source)) {
                                            \Filament\Notifications\Notification::make()->warning()->title('Rédigez l\'article d\'abord.')->send();
                                            return;
                                        }
                                        $prompt = "Rédige une balise meta-description ultra optimisée SEO pour ce texte. Idéalement entre 140 et 160 caractères. Orientée conversion et appel au clic. RETOURNE UNIQUEMENT LA META DESCRIPTION, SANS GUILLEMETS, SANS TEXTE AVANT OU APRES.";
                                        $generated = GeminiService::generateContent($prompt, strip_tags($source));
                                        if ($generated) {
                                            $form->fill([
                                                'suggested_meta' => \Illuminate\Support\Str::limit($generated, 255, '')
                                            ]);
                                        } else {
                                            \Filament\Notifications\Notification::make()->danger()->title('Problème IA.')->send();
                                        }
                                    })
                                    ->action(function (Forms\Set $set, array $data) {
                                        if (!empty($data['suggested_meta'])) {
                                            $set('meta_description', $data['suggested_meta']);
                                            \Filament\Notifications\Notification::make()->success()->title('Meta SEO remplacée !')->send();
                                        }
                                    })
                            )
                            ->maxLength(255),
                        Forms\Components\TagsInput::make('keywords')
                            ->label('Mots-clés SEO')
                            ->hintAction(
                                Action::make('generate_keywords')
                                    ->label('Mots-clés (IA)')
                                    ->icon('heroicon-o-sparkles')
                                    ->modalHeading('Propositions de Mots-clés SEO')
                                    ->modalSubmitActionLabel('Accepter et Remplacer')
                                    ->form([
                                        Forms\Components\TagsInput::make('suggested_keywords')
                                            ->label('Mots-clés proposés')
                                            ->separator(',')
                                            ->required(),
                                    ])
                                    ->mountUsing(function (Forms\ComponentContainer $form, Forms\Get $get) {
                                        $source = $get('html_content');
                                        if (empty($source)) {
                                            \Filament\Notifications\Notification::make()->warning()->title('Rédigez l\'article d\'abord.')->send();
                                            return;
                                        }
                                        $prompt = "Analyse ce texte et retourne une liste de 5 à 8 mots-clés hyper ciblés SEO. RETOURNE EXCLUSIVEMENT LES MOTS-CLÉS SÉPARÉS PAR DES VIRGULES. Exemple: mot1, mot2, mot clé composé 3, etc. SANS puces, SANS texte introductif.";
                                        $generated = GeminiService::generateContent($prompt, strip_tags($source));
                                        if ($generated) {
                                            $kw = array_map('trim', explode(',', $generated));
                                            $kw = array_filter($kw);
                                            $form->fill([
                                                'suggested_keywords' => $kw
                                            ]);
                                        } else {
                                            \Filament\Notifications\Notification::make()->danger()->title('Problème IA.')->send();
                                        }
                                    })
                                    ->action(function (Forms\Set $set, array $data) {
                                        if (!empty($data['suggested_keywords'])) {
                                            $set('keywords', $data['suggested_keywords']);
                                            \Filament\Notifications\Notification::make()->success()->title('Mots-clés insérés !')->send();
                                        }
                                    })
                            )
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
