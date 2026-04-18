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

                        ]),

                    Tab::make('RU')
                        ->schema([
                            ...static::galleryLanguageFields('ru'),
                            ...static::footerLanguageFields('ru'),
                            ...static::headerLanguageFields('ru'),

                        ]),

                    Tab::make('EN')
                        ->schema([
                            ...static::galleryLanguageFields('en'),
                            ...static::footerLanguageFields('en'),
                            ...static::headerLanguageFields('en'),

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
