<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du Quiz')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->label('Univers')
                            ->options([
                                'Esprit PEP' => 'Esprit PEP',
                                'Boîte à outils' => 'Boîte à outils',
                                'Pilotage' => 'Pilotage',
                                'Leadership' => 'Leadership',
                                'Flow' => 'Flow',
                            ])
                            ->required(),
                            
                        Forms\Components\TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('assist_title')
                                    ->icon('heroicon-m-sparkles')
                                    ->tooltip('Générer ou améliorer avec Gemini')
                                    ->action(function (Forms\Set $set, Forms\Get $get) {
                                        $category = $get('category');
                                        if (! $category) {
                                            \Filament\Notifications\Notification::make()->warning()->title('Catégorie requise')->body('Veuillez choisir un univers avant.')->send();
                                            return;
                                        }
                                        $draft = $get('title');
                                        $newTitle = \App\Services\GeminiService::improveQuizTitle($category, $draft);
                                        if ($newTitle) {
                                            $set('title', $newTitle);
                                        }
                                    })
                            ),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('Accroche')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('Quiz Actif en page d\'accueil')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Questions du Quiz')
                    ->headerActions([
                        Forms\Components\Actions\Action::make('generate_questions')
                            ->label('Ask Gemini (Deep Research)')
                            ->icon('heroicon-m-bolt')
                            ->color('warning')
                            ->requiresConfirmation()
                            ->modalHeading('Génération experte par IA')
                            ->modalDescription('Attention, le Deep Research écrasera vos questions (si non sauvegardées) pour en générer 10 nouvelles basées sur la catégorie.')
                            ->action(function (Forms\Set $set, Forms\Get $get) {
                                $category = $get('category');
                                $title = $get('title');
                                if (! $category || ! $title) {
                                    \Filament\Notifications\Notification::make()->warning()->title('Titre et Catégorie requis')->body('Requis pour contextualiser l\'IA.')->send();
                                    return;
                                }
                                
                                $questions = \App\Services\GeminiService::generateQuizQuestions($category, $title);
                                if ($questions) {
                                    $set('questions', $questions);
                                    \Filament\Notifications\Notification::make()->success()->title('Génération réussie !')->send();
                                } else {
                                    \Filament\Notifications\Notification::make()->danger()->title('Échec de la génération')->send();
                                }
                            })
                    ])
                    ->schema([
                        Forms\Components\Repeater::make('questions')
                            ->relationship()
                            ->label('')
                            ->schema([
                                Forms\Components\TextInput::make('question_text')
                                    ->label('La question')
                                    ->required(),
                                    
                                Forms\Components\Repeater::make('options')
                                    ->label('Options de réponse')
                                    ->schema([
                                        Forms\Components\TextInput::make('text')->label('Texte de la réponse')->required(),
                                        Forms\Components\Toggle::make('is_correct')->label('Bonne réponse'),
                                    ])
                                    ->columns(2)
                                    ->minItems(2)
                                    ->maxItems(5),
                                    
                                Forms\Components\Textarea::make('explanation')
                                    ->label('Explication formelle')
                                    ->nullable(),
                            ])
                            ->defaultItems(0)
                            ->collapsed(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Univers'),
                Tables\Columns\IconColumn::make('is_active')->label('Actif')->boolean(),
                Tables\Columns\TextColumn::make('questions_count')->counts('questions')->label('Nb Questions'),
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
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
