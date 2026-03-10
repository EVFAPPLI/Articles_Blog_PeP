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
                        
                        // L'éditeur de code HTML "Safe" pour les retouches manuelles sans filtrages (avec coloration VSCode)
                        Forms\Components\Section::make('Éditeur HTML & Assistant IA')
                            ->description('Modifiez le code source manuellement ou demandez à l\'IA de le faire pour vous.')
                            ->headerActions([
                                \Filament\Forms\Components\Actions\Action::make('preview_html')
                                    ->label('👁️ Aperçu visuel final')
                                    ->color('gray')
                                    ->modalHeading('Aperçu du rendu HTML')
                                    ->modalWidth('7xl')
                                    ->modalSubmitAction(false)
                                    ->modalCancelActionLabel('Fermer')
                                    ->form([
                                        Forms\Components\Placeholder::make('html_preview_render')
                                            ->label('')
                                            ->content(function (\Filament\Forms\Components\Placeholder $component) {
                                                // Accès 100% robuste à la donnée globale
                                                $html = data_get($component->getLivewire(), 'data.html_content', '');
                                                if (empty($html)) {
                                                    return new \Illuminate\Support\HtmlString('<p class="text-gray-500">Aucun contenu à afficher.</p>');
                                                }
                                                return new \Illuminate\Support\HtmlString('<div class="prose max-w-none ai-content break-words whitespace-pre-wrap overflow-hidden" style="padding:2rem; background:white; border-radius:8px;">' . $html . '</div>');
                                            })
                                    ]),
                                
                                \Filament\Forms\Components\Actions\Action::make('assistant_ia')
                                    ->label('✨ Assistant IA (Demander une modification)')
                                    ->color('success')
                                    ->modalHeading('Demander une retouche ciblée')
                                    ->modalWidth('7xl')
                                    ->modalDescription('Donnez une instruction à l\'IA (ex: "Mets cette phrase en bleu", "Passe tous les H2 en H3").')
                                    ->form([
                                        Forms\Components\TextInput::make('ia_instruction')
                                            ->label('Votre instruction')
                                            ->placeholder('Ex: Corrige la faute dans le titre...')
                                            ->required(),
                                        Forms\Components\Actions::make([
                                            Forms\Components\Actions\Action::make('generate_draft')
                                                ->label('Générer l\'aperçu')
                                                ->icon('heroicon-m-sparkles')
                                                ->color('primary')
                                                ->action(function (Forms\Get $get, Forms\Set $set, \Filament\Forms\Components\Actions\Action $action) {
                                                    $source = data_get($action->getLivewire(), 'data.html_content', '');
                                                    $instruction = $get('ia_instruction');

                                                    if (empty($source) || empty($instruction)) {
                                                        \Filament\Notifications\Notification::make()->warning()->title('L\'article ou l\'instruction est vide.')->send();
                                                        return;
                                                    }

                                                    \Filament\Notifications\Notification::make()->info()->title('Génération de l\'aperçu en cours...')->send();

                                                    $prompt = "Tu es un copywriter et développeur expert. 
                                                    Voici la demande de l'utilisateur : '{$instruction}'.
                                                    Applique CETTE demande sur le code HTML suivant sans rien détériorer.
                                                    CONSIGNES :
                                                    1. Renvoie UNIQUEMENT le code HTML modifié.
                                                    2. Ne supprime AUCUNE balise existante sauf si demandé.
                                                    3. Conserve rigoureusement les classes et la structure.";
                                                    
                                                    $result = GeminiService::generateContent($prompt, $source);
                                                    if ($result) {
                                                        $cleaned = preg_replace('/```html\n?(.*?)\n?```/is', '$1', $result);
                                                        $set('ai_generated_result', $cleaned);
                                                    }
                                                }),
                                        ])->alignCenter(),
                                        Forms\Components\Hidden::make('ai_generated_result'),
                                        Forms\Components\Placeholder::make('ai_generated_preview')
                                            ->label('Aperçu du nouveau rendu')
                                            ->content(function (Forms\Get $get) {
                                                $html = $get('ai_generated_result');
                                                if (empty($html)) {
                                                    return new \Illuminate\Support\HtmlString('<p class="text-gray-500 italic">L\'aperçu apparaîtra ici...</p>');
                                                }
                                                return new \Illuminate\Support\HtmlString('<div class="prose max-w-none ai-content break-words whitespace-pre-wrap overflow-hidden" style="padding:2rem; background:white; border-radius:8px; border:1px solid #e2e8f0;">' . $html . '</div>');
                                            })
                                            ->visible(fn (Forms\Get $get): bool => filled($get('ai_generated_result'))),
                                    ])
                                    ->modalSubmitActionLabel('Accepter la modification et remplacer')
                                    ->action(function (array $data, \Filament\Forms\Components\Actions\Action $action) {
                                        if (!empty($data['ai_generated_result'])) {
                                            $action->getLivewire()->data['html_content'] = $data['ai_generated_result'];
                                            \Filament\Notifications\Notification::make()->success()->title('La modification a été appliquée !')->send();
                                        } else {
                                            \Filament\Notifications\Notification::make()->danger()->title('Veuillez d\'abord "Générer" un aperçu.')->send();
                                        }
                                    }),

                                \Filament\Forms\Components\Actions\Action::make('auto_layout')
                                    ->label('🪄 Mise en page Intelligente')
                                    ->color('info')
                                    ->requiresConfirmation()
                                    ->modalHeading('Embellir la structure HTML ?')
                                    ->modalDescription('L\'IA va ajouter les bonnes balises HTML (titres h2, h3, paragraphes, listes) au texte actuel pour le rendre magnifique. RÈGLE D\'OR : L\'IA ne modifiera ou ne supprimera AUCUN mot ou phrase. Confirmez-vous ?')
                                    ->modalSubmitActionLabel('Oui, embellir la mise en page')
                                    ->action(function (Forms\Set $set, \Filament\Forms\Components\Actions\Action $action) {
                                        $source = data_get($action->getLivewire(), 'data.html_content', '');
                                        
                                        if (empty($source)) {
                                            \Filament\Notifications\Notification::make()->warning()->title('Le contenu est vide.')->send();
                                            return;
                                        }

                                        \Filament\Notifications\Notification::make()->info()->title('Analyse de la structure HTML en cours... Ce processus peut prendre quelques secondes.')->send();

                                        $prompt = "Tu es un expert formateur web. Refais la mise en page de ce texte pour le structurer intelligemment.
                                        RÈGLES D'OR ABSOLUES : 
                                        1. NE CHANGE AUCUN MOT DU TEXTE ORIGINAL. N'efface RIEN, particulièrement les sources.
                                        2. Ajoute des balises de base propres (<h2>, <h3>, <p>, <ul>, <li>, <strong>) mais AUCUNE classe (sauf pour le point 4).
                                        3. Rends TOUS les liens (URLs ou textes évoquant un lien) cliquables avec <a href=\"...\" target=\"_blank\">.
                                        4. DÉTECTION DES SOURCES : Enveloppe OBLIGATOIREMENT tout paragraphe parlant de sources, références ou statistiques (surtout en fin de texte) dans une <div class=\"ai-sources\">...</div>.
                                        Renvoie UNIQUEMENT le code HTML final pur, sans blocs de commentaires Markdown.";
                                        
                                        $improved = GeminiService::generateContent($prompt, $source);
                                        
                                        if ($improved) {
                                            $cleaned = preg_replace('/```html\n?(.*?)\n?```/is', '$1', $improved);
                                            // Modification globale de la Form parent
                                            $action->getLivewire()->data['html_content'] = $cleaned;
                                            \Filament\Notifications\Notification::make()->success()->title('Mise en page automatique réussie !')->send();
                                        } else {
                                            \Filament\Notifications\Notification::make()->danger()->title('Problème avec l\'IA. Vérifiez les logs.')->send();
                                        }
                                    }),
                            ])
                            ->schema([
                                \Dotswan\FilamentCodeEditor\Fields\CodeEditor::make('html_content')
                                    ->label('')
                                    ->minHeight(600)
                                    ->columnSpanFull(),
                            ])
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
