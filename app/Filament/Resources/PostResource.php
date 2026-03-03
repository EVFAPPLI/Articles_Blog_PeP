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
                                'IA' => 'IA',
                                'SEO' => 'SEO',
                                'Marketing' => 'Marketing',
                                'Immobilier' => 'Immobilier',
                                'Tech' => 'Tech',
                                'Social' => 'Social',
                                'Ecommerce' => 'E-commerce',
                                'Ecologie' => 'Ékologie/Environnement',
                                'Securite' => 'Sécurité',
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
                        
                        Forms\Components\Textarea::make('vignette_content')
                            ->label('Code HTML de la Vignette (Extrait)')
                            ->rows(5)
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('html_content')
                            ->label('Code HTML de l\'Article Complet')
                            ->rows(15)
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
                    ->sortable(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
