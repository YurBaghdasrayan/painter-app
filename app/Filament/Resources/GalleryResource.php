<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
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

class GalleryResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Gallery';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Gallery')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Forms\Components\Toggle::make('is_featured_on_home')
                        ->label('Show on Home')
                        ->default(false),

                    Forms\Components\TextInput::make('home_sort_order')
                        ->label('Home sort order')
                        ->helperText('Smaller = higher on home (0, 1, 2…). To put a work second, it must be 1 if the first is 0—not 2. Empty: gallery order after explicit home orders.')
                        ->numeric()
                        ->minValue(0)
                        ->default(null)
                        ->nullable(),

                    Forms\Components\TextInput::make('sort_order')
                        ->label('Gallery sort order')
                        ->helperText('Order on /gallery page.')
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
                                    Forms\Components\TextInput::make('same_line_title_am')
                                        ->label('Same line group (AM)')
                                        ->helperText('Optional: same value = shown together in "From the same line"')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('size_am')
                                        ->label('Size (AM)')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('material_am')
                                        ->label('Material (AM)')
                                        ->maxLength(255),
                                    RichEditor::make('short_description_am')
                                        ->label('Short description (AM)')
                                        ->columnSpanFull(),
                                    RichEditor::make('full_description_am')
                                        ->label('Long description (AM)')
                                        ->columnSpanFull(),

                                    Section::make('Show page (AM)')
                                        ->schema([
                                            Repeater::make('show_columns_am')
                                                ->label('3 text columns (below image)')
                                                ->schema([
                                                    RichEditor::make('text')
                                                        ->label('Text')
                                                        ->columnSpanFull(),
                                                ])
                                                ->maxItems(3)
                                                ->columnSpanFull(),
                                        ])
                                        ->columnSpanFull(),
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
                                    Forms\Components\TextInput::make('same_line_title_ru')
                                        ->label('Same line group (RU)')
                                        ->helperText('Optional: same value = shown together in "From the same line"')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('size_ru')
                                        ->label('Size (RU)')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('material_ru')
                                        ->label('Material (RU)')
                                        ->maxLength(255),
                                    RichEditor::make('short_description_ru')
                                        ->label('Short description (RU)')
                                        ->columnSpanFull(),
                                    RichEditor::make('full_description_ru')
                                        ->label('Long description (RU)')
                                        ->columnSpanFull(),

                                    Section::make('Show page (RU)')
                                        ->schema([
                                            Repeater::make('show_columns_ru')
                                                ->label('3 text columns (below image)')
                                                ->schema([
                                                    RichEditor::make('text')
                                                        ->label('Text')
                                                        ->columnSpanFull(),
                                                ])
                                                ->maxItems(3)
                                                ->columnSpanFull(),
                                        ])
                                        ->columnSpanFull(),
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
                                    Forms\Components\TextInput::make('same_line_title_en')
                                        ->label('Same line group (EN)')
                                        ->helperText('Optional: same value = shown together in "From the same line"')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('size_en')
                                        ->label('Size (EN)')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('material_en')
                                        ->label('Material (EN)')
                                        ->maxLength(255),
                                    RichEditor::make('short_description_en')
                                        ->label('Short description (EN)')
                                        ->columnSpanFull(),
                                    RichEditor::make('full_description_en')
                                        ->label('Long description (EN)')
                                        ->columnSpanFull(),

                                    Section::make('Show page (EN)')
                                        ->schema([
                                            Repeater::make('show_columns_en')
                                                ->label('3 text columns (below image)')
                                                ->schema([
                                                    RichEditor::make('text')
                                                        ->label('Text')
                                                        ->columnSpanFull(),
                                                ])
                                                ->maxItems(3)
                                                ->columnSpanFull(),
                                        ])
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    Section::make('Image')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->label('Image')
                                ->image()
                                ->required()
                                ->disk('public')
                                ->directory('gallery')
                                ->visibility('public')
                                ->imageEditor()
                                ->imagePreviewHeight('160')
                                ->openable()
                                ->downloadable()
                                ->columnSpanFull(),
                            Forms\Components\FileUpload::make('detail_images')
                                ->label('Detail images')
                                ->helperText('Optional: extra views under the main image — 3 per row on the artwork page. Drag to reorder.')
                                ->image()
                                ->multiple()
                                ->reorderable()
                                ->disk('public')
                                ->directory('gallery')
                                ->visibility('public')
                                ->imagePreviewHeight('100')
                                ->openable()
                                ->downloadable()
                                ->columnSpanFull(),
                        ])
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
                    ->getStateUsing(fn (GalleryItem $record): ?string => $record->image_thumb ?: $record->image)
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
                Tables\Columns\TextColumn::make('size_en')
                    ->label('Size')
                    ->limit(24),
                Tables\Columns\TextColumn::make('material_en')
                    ->label('Material')
                    ->limit(24),
                Tables\Columns\ToggleColumn::make('is_featured_on_home')
                    ->label('Home')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_sort_order')
                    ->label('Home order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Gallery order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                Tables\Filters\TernaryFilter::make('is_featured_on_home')->label('Show on Home'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}

