<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-swatch';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Gallery Items';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Artwork')
                    ->schema([
                        Forms\Components\Select::make('gallery_section_id')
                            ->label('Gallery section')
                            ->relationship('section', 'title_en')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured_on_home')
                            ->label('Featured on Home')
                            ->default(false),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Tabs::make('Translations')
                            ->columnSpanFull()
                            ->tabs([
                                Tab::make('AM')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_am')
                                            ->label('Title (AM)')
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                                if (!filled($get('slug')) && filled($state)) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                        Forms\Components\Textarea::make('short_description_am')
                                            ->label('Short description (AM)')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('full_description_am')
                                            ->label('Full description (AM)')
                                            ->rows(8)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('same_line_title_am')
                                            ->label('Same line title (AM)')
                                            ->maxLength(255),
                                    ]),
                                Tab::make('RU')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_ru')
                                            ->label('Title (RU)')
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                                if (!filled($get('slug')) && filled($state)) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                        Forms\Components\Textarea::make('short_description_ru')
                                            ->label('Short description (RU)')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('full_description_ru')
                                            ->label('Full description (RU)')
                                            ->rows(8)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('same_line_title_ru')
                                            ->label('Same line title (RU)')
                                            ->maxLength(255),
                                    ]),
                                Tab::make('EN')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_en')
                                            ->label('Title (EN)')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                                if (!filled($get('slug')) && filled($state)) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                        Forms\Components\Textarea::make('short_description_en')
                                            ->label('Short description (EN)')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('full_description_en')
                                            ->label('Full description (EN)')
                                            ->rows(8)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('same_line_title_en')
                                            ->label('Same line title (EN)')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        Section::make('Images')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Main image')
                                    ->image()
                                    ->required()
                                    ->disk('public')
                                    ->directory('gallery')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imagePreviewHeight('140')
                                    ->openable()
                                    ->downloadable()
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('secondary_image')
                                    ->label('Secondary image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('gallery')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imagePreviewHeight('120')
                                    ->openable()
                                    ->downloadable(),

                                Forms\Components\FileUpload::make('third_image')
                                    ->label('Third image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('gallery')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imagePreviewHeight('120')
                                    ->openable()
                                    ->downloadable(),

                                Forms\Components\FileUpload::make('fourth_image')
                                    ->label('Fourth image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('gallery')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imagePreviewHeight('120')
                                    ->openable()
                                    ->downloadable(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->square()
                    ->size(56),
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->limit(36),
                Tables\Columns\ToggleColumn::make('is_featured_on_home')
                    ->label('Home')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                Tables\Filters\TernaryFilter::make('is_featured_on_home')->label('Featured on Home'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryItems::route('/'),
            'create' => Pages\CreateGalleryItem::route('/create'),
            'edit' => Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }
}

