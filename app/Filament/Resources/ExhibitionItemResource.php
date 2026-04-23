<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExhibitionItemResource\Pages;
use App\Models\ExhibitionItem;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ExhibitionItemResource extends Resource
{
    protected static ?string $model = ExhibitionItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-group';
    protected static string|\UnitEnum|null $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Exhibition Items';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Exhibition Item')
                ->schema([
                    Forms\Components\Select::make('exhibition_id')
                        ->label('Exhibition')
                        ->relationship('exhibition', 'title_en')
                        ->searchable()
                        ->preload()
                        ->required(),

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
                        ->directory('exhibitions/items')
                        ->visibility('public')
                        ->imageEditor()
                        ->imagePreviewHeight('140')
                        ->openable()
                        ->downloadable()
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('secondary_image')
                        ->label('Image 2')
                        ->image()
                        ->disk('public')
                        ->directory('exhibitions/items')
                        ->visibility('public')
                        ->imageEditor()
                        ->imagePreviewHeight('140')
                        ->openable()
                        ->downloadable(),

                    Forms\Components\FileUpload::make('third_image')
                        ->label('Image 3')
                        ->image()
                        ->disk('public')
                        ->directory('exhibitions/items')
                        ->visibility('public')
                        ->imageEditor()
                        ->imagePreviewHeight('140')
                        ->openable()
                        ->downloadable(),

                    Forms\Components\FileUpload::make('fourth_image')
                        ->label('Image 4')
                        ->image()
                        ->disk('public')
                        ->directory('exhibitions/items')
                        ->visibility('public')
                        ->imageEditor()
                        ->imagePreviewHeight('140')
                        ->openable()
                        ->downloadable(),

                    Tabs::make('Translations')
                        ->columnSpanFull()
                        ->tabs([
                            Tab::make('AM')
                                ->schema([
                                    Forms\Components\TextInput::make('title_am')
                                        ->label('Title (AM)')
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('description_am')
                                        ->label('Description (AM)')
                                        ->rows(6)
                                        ->columnSpanFull(),
                                ]),
                            Tab::make('RU')
                                ->schema([
                                    Forms\Components\TextInput::make('title_ru')
                                        ->label('Title (RU)')
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('description_ru')
                                        ->label('Description (RU)')
                                        ->rows(6)
                                        ->columnSpanFull(),
                                ]),
                            Tab::make('EN')
                                ->schema([
                                    Forms\Components\TextInput::make('title_en')
                                        ->label('Title (EN)')
                                        ->maxLength(255),
                                    Forms\Components\Textarea::make('description_en')
                                        ->label('Description (EN)')
                                        ->rows(6)
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
                Tables\Columns\TextColumn::make('exhibition.title_en')
                    ->label('Exhibition')
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
            'index' => Pages\ListExhibitionItems::route('/'),
            'create' => Pages\CreateExhibitionItem::route('/create'),
            'edit' => Pages\EditExhibitionItem::route('/{record}/edit'),
        ];
    }
}

