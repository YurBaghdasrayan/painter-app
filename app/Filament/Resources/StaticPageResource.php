<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaticPageResource\Pages\CreateStaticPage;
use App\Filament\Resources\StaticPageResource\Pages\EditStaticPage;
use App\Filament\Resources\StaticPageResource\Pages\ListStaticPages;
use App\Models\StaticPage;
use BackedEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class StaticPageResource extends Resource
{
    protected static ?string $model = StaticPage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Content';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Static Pages';
    protected static ?string $modelLabel = 'Static Page';
    protected static ?string $pluralModelLabel = 'Static Pages';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Page Settings')
                ->schema([
                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->live(),

                    TextInput::make('title')
                        ->maxLength(255),

                    Toggle::make('is_active')
                        ->default(true),
                ]),

            Tabs::make('Translations')
                ->tabs([
                    Tab::make('AM')
                        ->schema([
                            ...static::galleryLanguageFields('am'),
                            ...static::footerLanguageFields('am'),
                            ...static::headerLanguageFields('am'),
                            ...static::homeLanguageFields('am'),
                            ...static::articlesLanguageFields('am'),


                        ]),

                    Tab::make('RU')
                        ->schema([
                            ...static::galleryLanguageFields('ru'),
                            ...static::footerLanguageFields('ru'),
                            ...static::headerLanguageFields('ru'),
                            ...static::homeLanguageFields('ru'),
                            ...static::articlesLanguageFields('ru'),


                        ]),

                    Tab::make('EN')
                        ->schema([
                            ...static::galleryLanguageFields('en'),
                            ...static::footerLanguageFields('en'),
                            ...static::headerLanguageFields('en'),
                            ...static::homeLanguageFields('en'),
                            ...static::articlesLanguageFields('en'),

                        ]),
                ]),
        ]);
    }

    protected static function galleryLanguageFields(string $locale): array
    {
        return [
            Section::make("Gallery hero {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'gallery')
                ->schema([
                    TextInput::make("content_{$locale}.hero.title")
                        ->label('Hero title')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.hero.subtitle")
                        ->label('Hero subtitle')
                        ->maxLength(1000),
                ]),

            Section::make("Gallery bottom feature {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'gallery')
                ->schema([
                    TextInput::make("content_{$locale}.bottom_feature_section.title")
                        ->label('Section title')
                        ->maxLength(255),

                    FileUpload::make("content_{$locale}.bottom_feature_section.image")
                        ->label('Section image')
                        ->image()
                        ->disk('public')
                        ->directory('static/gallery')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.bottom_feature_section.button_link")
                        ->label('Button link')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.bottom_feature_section.items.0")
                        ->label('Description 1'),

                    RichEditor::make("content_{$locale}.bottom_feature_section.items.1")
                        ->label('Description 2'),

                    RichEditor::make("content_{$locale}.bottom_feature_section.items.2")
                        ->label('Description 3'),
                ]),
        ];
    }

    protected static function footerLanguageFields(string $locale): array
    {
        return [
            Section::make("Footer {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'footer')
                ->schema([
                    TextInput::make("content_{$locale}.top_text")
                        ->label('Top text')
                        ->maxLength(255),

                    Repeater::make("content_{$locale}.menu")
                        ->label('Footer menu')
                        ->schema([
                            TextInput::make('label')
                                ->label('Label')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('url')
                                ->label('URL')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->defaultItems(0)
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(function (array $state): ?string {
                            return $state['label'] ?? null;
                        }),
                ]),
        ];
    }
    protected static function headerLanguageFields(string $locale): array
    {
        return [
            Section::make("Header {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'header')
                ->schema([

                    TextInput::make("content_{$locale}.top_text")
                        ->label('Top text'),

                    Repeater::make("content_{$locale}.menu")
                        ->label('Menu')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')->required(),
                        ])
                        ->reorderable()
                        ->collapsible()
                        ->defaultItems(0),
                ]),
        ];
    }
    protected static function homeLanguageFields(string $locale): array
    {
        return [
            Section::make("Home articles {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'home')
                ->schema([
                    TextInput::make("content_{$locale}.articles_section.title")
                        ->label('Section title')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.articles_section.left_text")
                        ->label('Left text')
                        ->maxLength(2000),

                    TextInput::make("content_{$locale}.articles_section.right_text")
                        ->label('Right text')
                        ->maxLength(3000),

                    FileUpload::make("content_{$locale}.articles_section.main_image")
                        ->label('Main image')
                        ->image()
                        ->disk('public')
                        ->directory('static/home')
                        ->visibility('public'),

                    FileUpload::make("content_{$locale}.articles_section.side_image")
                        ->label('Side image')
                        ->image()
                        ->disk('public')
                        ->directory('static/home')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.articles_section.card_title")
                        ->label('Card title')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.articles_section.card_text")
                        ->label('Card text')
                        ->maxLength(3000),

                    TextInput::make("content_{$locale}.articles_section.more_text")
                        ->label('More text')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.articles_section.more_link")
                        ->label('More link')
                        ->maxLength(255),
                ]),
        ];
    }
    protected static function articlesLanguageFields(string $locale): array
    {
        return [
            Section::make("Articles {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'articles')
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
                        ->directory('static/articles')
                        ->visibility('public'),

                    FileUpload::make("content_{$locale}.hero.main_image")
                        ->label('Hero main image')
                        ->image()
                        ->disk('public')
                        ->directory('static/articles')
                        ->visibility('public'),

                    RichEditor::make("content_{$locale}.intro_section.columns.0")
                        ->label('Column 1'),

                    RichEditor::make("content_{$locale}.intro_section.columns.1")
                        ->label('Column 2'),

                    RichEditor::make("content_{$locale}.intro_section.columns.2")
                        ->label('Column 3'),
                ]),
        ];
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
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
            'index' => ListStaticPages::route('/'),
            'create' => CreateStaticPage::route('/create'),
            'edit' => EditStaticPage::route('/{record}/edit'),
        ];
    }
}
