<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GallerySectionResource\Pages;
use App\Filament\Resources\GallerySectionResource\RelationManagers\GalleryItemsRelationManager;
use App\Models\GallerySection;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
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
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('left_text')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('right_text')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('more_button_text')
                            ->required()
                            ->maxLength(50)
                            ->default('more'),
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
                Tables\Columns\TextColumn::make('title')
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
            GalleryItemsRelationManager::class,
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

