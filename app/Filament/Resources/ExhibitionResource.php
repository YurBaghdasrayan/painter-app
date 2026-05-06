<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExhibitionResource\Pages;
use App\Models\Exhibition;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ExhibitionResource extends Resource
{
    protected static ?string $model = Exhibition::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';
    protected static string|\UnitEnum|null $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Exhibitions';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Exhibition')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),

                    Forms\Components\FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->disk('public')
                        ->directory('exhibitions')
                        ->visibility('public')
                        ->imageEditor()
                        ->imagePreviewHeight('140')
                        ->openable()
                        ->downloadable()
                        ->columnSpanFull(),

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
                                ]),
                            Tab::make('RU')
                                ->schema([
                                    Forms\Components\TextInput::make('title_ru')
                                        ->label('Title (RU)')
                                        ->maxLength(255),
                                    RichEditor::make('description_ru')
                                        ->label('Description (RU)')
                                        ->columnSpanFull(),
                                ]),
                            Tab::make('EN')
                                ->schema([
                                    Forms\Components\TextInput::make('title_en')
                                        ->label('Title (EN)')
                                        ->maxLength(255),
                                    RichEditor::make('description_en')
                                        ->label('Description (EN)')
                                        ->columnSpanFull(),
                                ]),
                        ]),
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
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExhibitions::route('/'),
            'create' => Pages\CreateExhibition::route('/create'),
            'edit' => Pages\EditExhibition::route('/{record}/edit'),
        ];
    }
}

