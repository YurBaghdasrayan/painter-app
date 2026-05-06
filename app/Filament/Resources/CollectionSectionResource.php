<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionSectionResource\Pages;
use App\Models\CollectionSection;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CollectionSectionResource extends Resource
{
    protected static ?string $model = CollectionSection::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string|\UnitEnum|null $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Collection Sections';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Collection Section')
                ->schema([
                    Tabs::make('Translations')
                        ->columnSpanFull()
                        ->tabs([
                            Tab::make('AM')
                                ->schema([
                                    Forms\Components\TextInput::make('title_am')
                                        ->label('Title (AM)')
                                        ->maxLength(255),
                                    RichEditor::make('description_am')
                                        ->label('Description (AM)')
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
                                    RichEditor::make('description_ru')
                                        ->label('Description (RU)')
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
                                    RichEditor::make('description_en')
                                        ->label('Description (EN)')
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
            ->recordUrl(fn (CollectionSection $record) => static::getUrl('edit', ['record' => $record]));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollectionSections::route('/'),
            'create' => Pages\CreateCollectionSection::route('/create'),
            'edit' => Pages\EditCollectionSection::route('/{record}/edit'),
        ];
    }
}

