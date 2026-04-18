<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GallerySectionResource\Pages;
use App\Models\GallerySection;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GallerySectionResource extends Resource
{
    protected static ?string $model = GallerySection::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Gallery Section')
                    ->schema([
                        Tabs::make('Translations')
                            ->columnSpanFull()
                            ->tabs([
                                Tab::make('AM')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_am')
                                            ->label('Title (AM)')
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('left_text_am')
                                            ->label('Left text (AM)')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('right_text_am')
                                            ->label('Right text (AM)')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('more_button_text_am')
                                            ->label('More button text (AM)')
                                            ->maxLength(50)
                                            ->default('more'),
                                    ]),
                                Tab::make('RU')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_ru')
                                            ->label('Title (RU)')
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('left_text_ru')
                                            ->label('Left text (RU)')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('right_text_ru')
                                            ->label('Right text (RU)')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('more_button_text_ru')
                                            ->label('More button text (RU)')
                                            ->maxLength(50)
                                            ->default('more'),
                                    ]),
                                Tab::make('EN')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_en')
                                            ->label('Title (EN)')
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('left_text_en')
                                            ->label('Left text (EN)')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('right_text_en')
                                            ->label('Right text (EN)')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('more_button_text_en')
                                            ->label('More button text (EN)')
                                            ->maxLength(50)
                                            ->default('more'),
                                    ]),
                            ]),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->recordUrl(fn (GallerySection $record) => static::getUrl('edit', ['record' => $record]));
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
            'index' => Pages\ListGallerySections::route('/'),
            'create' => Pages\CreateGallerySection::route('/create'),
            'edit' => Pages\EditGallerySection::route('/{record}/edit'),
        ];
    }
}

