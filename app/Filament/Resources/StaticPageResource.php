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
                            ...static::aboutLanguageFields('am'),
                            ...static::articlesLanguageFields('am'),


                        ]),

                    Tab::make('RU')
                        ->schema([
                            ...static::galleryLanguageFields('ru'),
                            ...static::footerLanguageFields('ru'),
                            ...static::headerLanguageFields('ru'),
                            ...static::homeLanguageFields('ru'),
                            ...static::aboutLanguageFields('ru'),
                            ...static::articlesLanguageFields('ru'),


                        ]),

                    Tab::make('EN')
                        ->schema([
                            ...static::galleryLanguageFields('en'),
                            ...static::footerLanguageFields('en'),
                            ...static::headerLanguageFields('en'),
                            ...static::homeLanguageFields('en'),
                            ...static::aboutLanguageFields('en'),
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

                    FileUpload::make("content_{$locale}.hero.background_image")
                        ->label('Hero background image')
                        ->image()
                        ->disk('public')
                        ->directory('static/gallery')
                        ->visibility('public'),

                    FileUpload::make("content_{$locale}.hero.main_image")
                        ->label('Hero floating image')
                        ->image()
                        ->disk('public')
                        ->directory('static/gallery')
                        ->visibility('public'),
                ]),

            Section::make("Gallery show hero {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'gallery')
                ->schema([
                    TextInput::make("content_{$locale}.show_hero.title")
                        ->label('Show hero title')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.show_hero.subtitle")
                        ->label('Show hero subtitle')
                        ->maxLength(1500),

                    FileUpload::make("content_{$locale}.show_hero.background_image")
                        ->label('Show hero background image')
                        ->image()
                        ->disk('public')
                        ->directory('static/gallery')
                        ->visibility('public'),
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
            Section::make("Home hero {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'home')
                ->schema([
                    TextInput::make("content_{$locale}.hero.title")
                        ->label('Hero title')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.hero.subtitle")
                        ->label('Hero subtitle')
                        ->maxLength(1000),
                ]),

            Section::make("Home about {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'home')
                ->schema([
                    FileUpload::make("content_{$locale}.about_section.background_image")
                        ->label('Background image')
                        ->image()
                        ->disk('public')
                        ->directory('static/home')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.about_section.kicker")
                        ->label('Kicker')
                        ->maxLength(80),

                    TextInput::make("content_{$locale}.about_section.title")
                        ->label('Title')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.about_section.lead")
                        ->label('Lead')
                        ->maxLength(1000),

                    TextInput::make("content_{$locale}.about_section.items.0")
                        ->label('Bullet 1')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.about_section.items.1")
                        ->label('Bullet 2')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.about_section.items.2")
                        ->label('Bullet 3')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.about_section.lower_text")
                        ->label('Lower text')
                        ->maxLength(2000),

                    TextInput::make("content_{$locale}.about_section.button_text")
                        ->label('Button text')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.about_section.button_link")
                        ->label('Button link')
                        ->maxLength(255),
                ]),

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

    protected static function aboutLanguageFields(string $locale): array
    {
        return [
            Section::make("About hero {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'about')
                ->schema([
                    TextInput::make("content_{$locale}.hero.title")
                        ->label('Hero title')
                        ->maxLength(255),

                    TextInput::make("content_{$locale}.hero.subtitle")
                        ->label('Hero subtitle')
                        ->maxLength(1500),

                    FileUpload::make("content_{$locale}.hero.background_image")
                        ->label('Hero background image')
                        ->image()
                        ->disk('public')
                        ->directory('static/about')
                        ->visibility('public'),
                ]),

            Section::make("About profile {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'about')
                ->schema([
                    FileUpload::make("content_{$locale}.profile_section.image")
                        ->label('Profile image')
                        ->image()
                        ->disk('public')
                        ->directory('static/about')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.profile_section.name")
                        ->label('Name')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.profile_section.text")
                        ->label('Bio text'),
                ]),

            Section::make("About video {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'about')
                ->schema([
                    TextInput::make("content_{$locale}.video_section.youtube_url")
                        ->label('YouTube URL')
                        ->maxLength(2000),

                    FileUpload::make("content_{$locale}.video_section.thumbnail_image")
                        ->label('Video thumbnail image')
                        ->image()
                        ->disk('public')
                        ->directory('static/about')
                        ->visibility('public'),

                    RichEditor::make("content_{$locale}.video_section.columns.0")
                        ->label('Column 1'),

                    RichEditor::make("content_{$locale}.video_section.columns.1")
                        ->label('Column 2'),

                    RichEditor::make("content_{$locale}.video_section.columns.2")
                        ->label('Column 3'),
                ]),

            Section::make("About feature {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'about')
                ->schema([
                    TextInput::make("content_{$locale}.feature_section.title")
                        ->label('Title')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.feature_section.top_left")
                        ->label('Top left text'),

                    RichEditor::make("content_{$locale}.feature_section.top_right")
                        ->label('Top right text'),

                    FileUpload::make("content_{$locale}.feature_section.image")
                        ->label('Image')
                        ->image()
                        ->disk('public')
                        ->directory('static/about')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.feature_section.button_link")
                        ->label('Button link')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.feature_section.bottom_left")
                        ->label('Bottom left text'),

                    RichEditor::make("content_{$locale}.feature_section.bottom_right")
                        ->label('Bottom right text'),
                ]),

            Section::make("About duo {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'about')
                ->schema([
                    FileUpload::make("content_{$locale}.duo_section.left.image")
                        ->label('Left image')
                        ->image()
                        ->disk('public')
                        ->directory('static/about')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.duo_section.left.title")
                        ->label('Left title')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.duo_section.left.text")
                        ->label('Left text'),

                    FileUpload::make("content_{$locale}.duo_section.right.image")
                        ->label('Right image')
                        ->image()
                        ->disk('public')
                        ->directory('static/about')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.duo_section.right.title")
                        ->label('Right title')
                        ->maxLength(255),

                    RichEditor::make("content_{$locale}.duo_section.right.text")
                        ->label('Right text'),
                ]),

            Section::make("About quad {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'about')
                ->schema([
                    FileUpload::make("content_{$locale}.quad_section.center_image")
                        ->label('Center image')
                        ->image()
                        ->disk('public')
                        ->directory('static/about')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.quad_section.left_top.title")
                        ->label('Left top title')
                        ->maxLength(255),
                    RichEditor::make("content_{$locale}.quad_section.left_top.text")
                        ->label('Left top text'),

                    TextInput::make("content_{$locale}.quad_section.left_bottom.title")
                        ->label('Left bottom title')
                        ->maxLength(255),
                    RichEditor::make("content_{$locale}.quad_section.left_bottom.text")
                        ->label('Left bottom text'),

                    TextInput::make("content_{$locale}.quad_section.right_top.title")
                        ->label('Right top title')
                        ->maxLength(255),
                    RichEditor::make("content_{$locale}.quad_section.right_top.text")
                        ->label('Right top text'),

                    TextInput::make("content_{$locale}.quad_section.right_bottom.title")
                        ->label('Right bottom title')
                        ->maxLength(255),
                    RichEditor::make("content_{$locale}.quad_section.right_bottom.text")
                        ->label('Right bottom text'),
                ]),

            Section::make("About final {$locale}")
                ->visible(fn (Get $get) => $get('slug') === 'about')
                ->schema([
                    FileUpload::make("content_{$locale}.final_section.image")
                        ->label('Top image')
                        ->image()
                        ->disk('public')
                        ->directory('static/about')
                        ->visibility('public'),

                    TextInput::make("content_{$locale}.final_section.left.title")
                        ->label('Left title')
                        ->maxLength(255),
                    RichEditor::make("content_{$locale}.final_section.left.text")
                        ->label('Left text'),

                    TextInput::make("content_{$locale}.final_section.right.title")
                        ->label('Right title')
                        ->maxLength(255),
                    RichEditor::make("content_{$locale}.final_section.right.text")
                        ->label('Right text'),
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
