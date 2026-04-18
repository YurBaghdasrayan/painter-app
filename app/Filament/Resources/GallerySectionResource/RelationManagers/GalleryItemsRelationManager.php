<?php

namespace App\Filament\Resources\GallerySectionResource\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Gallery Items';

    protected function getItemFormSchema(): array
    {
        return [
            Forms\Components\FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('gallery')
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
                            Forms\Components\Textarea::make('description_am')
                                ->label('Description (AM)')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                    Tab::make('RU')
                        ->schema([
                            Forms\Components\TextInput::make('title_ru')
                                ->label('Title (RU)')
                                ->maxLength(255),
                            Forms\Components\Textarea::make('description_ru')
                                ->label('Description (RU)')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                    Tab::make('EN')
                        ->schema([
                            Forms\Components\TextInput::make('title_en')
                                ->label('Title (EN)')
                                ->maxLength(255),
                            Forms\Components\Textarea::make('description_en')
                                ->label('Description (EN)')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                ]),
            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0)
                ,
            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(true),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                ...$this->getItemFormSchema(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                Actions\CreateAction::make('create')
                    ->label('Add item')
                    ->icon('heroicon-o-plus')
                    ->modalHeading('Add gallery item')
                    ->form(fn () => $this->getItemFormSchema())
                    ->using(function (array $data): void {
                        $this->getRelationship()->create($data);
                    }),
            ])
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
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->actions([
                Actions\EditAction::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->modalHeading('Edit gallery item')
                    ->form(fn () => $this->getItemFormSchema())
                    ->using(function ($record, array $data): void {
                        $record->update($data);
                    }),
                Actions\DeleteAction::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->using(function ($record): void {
                        $record->delete();
                    }),
            ]);
    }
}

