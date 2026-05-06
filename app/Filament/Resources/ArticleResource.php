<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Articles\Pages;
use App\Models\Article;
use BackedEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|UnitEnum|null $navigationGroup = 'Content';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Articles';
    protected static ?string $modelLabel = 'Article';
    protected static ?string $pluralModelLabel = 'Articles';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Article Settings')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->default(true),

                        Section::make('Card content')
                            ->schema([
                                Tabs::make('Card translations')
                                    ->tabs([
                                        Tab::make('AM')
                                            ->schema([
                                                FileUpload::make('content_am.card.image')
                                                    ->label('Image AM')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('articles/cards'),

                                                TextInput::make('content_am.card.title')
                                                    ->label('Title AM')
                                                    ->default('')
                                                    ->maxLength(255),

                                                RichEditor::make('content_am.card.description')
                                                    ->label('Description AM')
                                                    ->default(''),
                                            ]),

                                        Tab::make('RU')
                                            ->schema([
                                                FileUpload::make('content_ru.card.image')
                                                    ->label('Image RU')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('articles/cards'),

                                                TextInput::make('content_ru.card.title')
                                                    ->label('Title RU')
                                                    ->default('')
                                                    ->maxLength(255),

                                                RichEditor::make('content_ru.card.description')
                                                    ->label('Description RU')
                                                    ->default(''),
                                            ]),

                                        Tab::make('EN')
                                            ->schema([
                                                FileUpload::make('content_en.card.image')
                                                    ->label('Image EN')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('articles/cards'),

                                                TextInput::make('content_en.card.title')
                                                    ->label('Title EN')
                                                    ->default('')
                                                    ->maxLength(255),

                                                RichEditor::make('content_en.card.description')
                                                    ->label('Description EN')
                                                    ->default(''),
                                            ]),
                                    ]),
                            ]),
                    ]),

                Tabs::make('Translations')
                    ->columnSpan(1)
                    ->tabs([
                        Tab::make('AM')->schema(static::languageFields('am')),
                        Tab::make('RU')->schema(static::languageFields('ru')),
                        Tab::make('EN')->schema(static::languageFields('en')),
                    ]),
            ]);
    }

    protected static function languageFields(string $locale): array
    {
        return [
            Section::make("Base {$locale}")
                ->schema([
                    TextInput::make("title_{$locale}")
                        ->label('Page title')
                        ->maxLength(255),
                ]),

            Section::make("Hero section {$locale}")
                ->schema([
                    TextInput::make("content_{$locale}.hero.title")
                        ->label('Hero title')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.hero.subtitle")
                        ->label('Hero subtitle')
                        ->maxLength(1000),

                    FileUpload::make("content_{$locale}.hero.background_image")
                        ->label('Hero background image')
                        ->image()
                        ->disk('public')
                        ->directory('articles'),

                    FileUpload::make("content_{$locale}.hero.main_image")
                        ->label('Hero main image')
                        ->image()
                        ->disk('public')
                        ->directory('articles'),
                ]),

            Section::make("Text block 1 {$locale}")
                ->schema([
                    TextInput::make("content_{$locale}.text_block_1.left_title")
                        ->label('Left title')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.text_block_1.left_text")
                        ->label('Left text'),

                    TextInput::make("content_{$locale}.text_block_1.right_title")
                        ->label('Right title')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.text_block_1.right_text")
                        ->label('Right text'),
                ]),

            Section::make("Image block 1 {$locale}")
                ->schema([
                    FileUpload::make("content_{$locale}.image_block_1.image")
                        ->label('Image 1')
                        ->image()
                        ->disk('public')
                        ->directory('articles'),

                    RichEditor::make("content_{$locale}.image_block_1.left_text")
                        ->label('Left text under image'),

                    RichEditor::make("content_{$locale}.image_block_1.right_text")
                        ->label('Right text under image'),
                ]),

            Section::make("Text block 2 {$locale}")
                ->schema([
                    TextInput::make("content_{$locale}.text_block_2.title")
                        ->label('Block title')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.text_block_2.left_text")
                        ->label('Left text'),

                    RichEditor::make("content_{$locale}.text_block_2.right_text")
                        ->label('Right text'),
                ]),

            Section::make("Image block 2 {$locale}")
                ->schema([
                    FileUpload::make("content_{$locale}.image_block_2.image")
                        ->label('Image 2')
                        ->image()
                        ->disk('public')
                        ->directory('articles'),

                    RichEditor::make("content_{$locale}.image_block_2.left_text")
                        ->label('Left text under second image'),

                    RichEditor::make("content_{$locale}.image_block_2.right_text")
                        ->label('Right text under second image'),
                ]),

            Section::make("Text block 3 {$locale}")
                ->schema([
                    TextInput::make("content_{$locale}.text_block_3.title")
                        ->label('Bottom title')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.text_block_3.left_text")
                        ->label('Bottom left text'),

                    RichEditor::make("content_{$locale}.text_block_3.right_text")
                        ->label('Bottom right text'),
                ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('content_en.card.image')
                    ->label('Card image')
                    ->disk('public'),

                Tables\Columns\TextColumn::make('content_en.card.title')
                    ->label('Card title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
