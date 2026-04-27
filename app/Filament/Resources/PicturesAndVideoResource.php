<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PicturesAndVideoResource\Pages;
use App\Models\PicturesAndVideo;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PicturesAndVideoResource extends Resource
{
    protected static ?string $model = PicturesAndVideo::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';
    protected static string|\UnitEnum|null $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Pictures & Videos';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Pictures & Videos')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),

                    Section::make('First block (5 photos)')
                        ->schema([
                            static::photoBlockFields(0, 'Photo 1'),
                            static::photoBlockFields(1, 'Photo 2'),
                            static::photoBlockFields(2, 'Photo 3'),
                            static::photoBlockFields(3, 'Photo 4'),
                            static::photoBlockFields(4, 'Photo 5'),
                        ])
                        ->columnSpanFull(),

                    Section::make('Second block (video + 7 images)')
                        ->schema([
                            Tabs::make('Second block texts')
                                ->tabs([
                                    Tab::make('AM')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.second_block.title_am')
                                                ->label('Title (AM)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.second_block.text_am')
                                                ->label('Text (AM)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.second_block.bottom_text_am')
                                                ->label('Bottom text (AM)')
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('RU')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.second_block.title_ru')
                                                ->label('Title (RU)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.second_block.text_ru')
                                                ->label('Text (RU)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.second_block.bottom_text_ru')
                                                ->label('Bottom text (RU)')
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('EN')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.second_block.title_en')
                                                ->label('Title (EN)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.second_block.text_en')
                                                ->label('Text (EN)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.second_block.bottom_text_en')
                                                ->label('Bottom text (EN)')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('content.second_block.video')
                                ->label('Video file (mp4)')
                                ->disk('public')
                                ->directory('pictures-and-videos/video')
                                ->visibility('public')
                                ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                                ->openable()
                                ->downloadable()
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('content.second_block.video_poster')
                                ->label('Video poster image (optional)')
                                ->image()
                                ->disk('public')
                                ->directory('pictures-and-videos/video')
                                ->visibility('public')
                                ->imageEditor()
                                ->imagePreviewHeight('140')
                                ->openable()
                                ->downloadable()
                                ->columnSpanFull(),

                            Section::make('7 images')
                                ->schema([
                                    static::secondBlockItemFields(0, 'Image 1'),
                                    static::secondBlockItemFields(1, 'Image 2'),
                                    static::secondBlockItemFields(2, 'Image 3'),
                                    static::secondBlockItemFields(3, 'Image 4'),
                                    static::secondBlockItemFields(4, 'Image 5 (wide left)'),
                                    static::secondBlockItemFields(5, 'Image 6 (right top)'),
                                    static::secondBlockItemFields(6, 'Image 7 (right bottom)'),
                                ])
                                ->columns(1)
                                ->columnSpanFull(),
                        ])
                        ->collapsed()
                        ->columnSpanFull(),

                    Section::make('Third block (2 videos + texts)')
                        ->schema([
                            Tabs::make('Third block texts')
                                ->tabs([
                                    Tab::make('AM')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.third_block.title_am')
                                                ->label('Title (AM)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.third_block.top_left_text_am')
                                                ->label('Top left text (AM)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.top_right_text_am')
                                                ->label('Top right text (AM)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.bottom_left_text_am')
                                                ->label('Bottom left text (AM)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.bottom_right_text_am')
                                                ->label('Bottom right text (AM)')
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('RU')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.third_block.title_ru')
                                                ->label('Title (RU)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.third_block.top_left_text_ru')
                                                ->label('Top left text (RU)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.top_right_text_ru')
                                                ->label('Top right text (RU)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.bottom_left_text_ru')
                                                ->label('Bottom left text (RU)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.bottom_right_text_ru')
                                                ->label('Bottom right text (RU)')
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('EN')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.third_block.title_en')
                                                ->label('Title (EN)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.third_block.top_left_text_en')
                                                ->label('Top left text (EN)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.top_right_text_en')
                                                ->label('Top right text (EN)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.bottom_left_text_en')
                                                ->label('Bottom left text (EN)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.third_block.bottom_right_text_en')
                                                ->label('Bottom right text (EN)')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),

                            Section::make('Left video')
                                ->schema([
                                    Forms\Components\FileUpload::make('content.third_block.left_video')
                                        ->label('Left video file (mp4)')
                                        ->disk('public')
                                        ->directory('pictures-and-videos/video')
                                        ->visibility('public')
                                        ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                                        ->openable()
                                        ->downloadable()
                                        ->columnSpanFull(),
                                    Forms\Components\FileUpload::make('content.third_block.left_video_poster')
                                        ->label('Left video poster (optional)')
                                        ->image()
                                        ->disk('public')
                                        ->directory('pictures-and-videos/video')
                                        ->visibility('public')
                                        ->imageEditor()
                                        ->imagePreviewHeight('140')
                                        ->openable()
                                        ->downloadable()
                                        ->columnSpanFull(),
                                ])
                                ->collapsed(),

                            Section::make('Right video')
                                ->schema([
                                    Forms\Components\FileUpload::make('content.third_block.right_video')
                                        ->label('Right video file (mp4)')
                                        ->disk('public')
                                        ->directory('pictures-and-videos/video')
                                        ->visibility('public')
                                        ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                                        ->openable()
                                        ->downloadable()
                                        ->columnSpanFull(),
                                    Forms\Components\FileUpload::make('content.third_block.right_video_poster')
                                        ->label('Right video poster (optional)')
                                        ->image()
                                        ->disk('public')
                                        ->directory('pictures-and-videos/video')
                                        ->visibility('public')
                                        ->imageEditor()
                                        ->imagePreviewHeight('140')
                                        ->openable()
                                        ->downloadable()
                                        ->columnSpanFull(),
                                ])
                                ->collapsed(),
                        ])
                        ->collapsed()
                        ->columnSpanFull(),

                    Section::make('After slider block (video + texts)')
                        ->schema([
                            Tabs::make('After slider texts')
                                ->tabs([
                                    Tab::make('AM')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.after_slider_block.title_am')
                                                ->label('Title (AM)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.after_slider_block.top_text_am')
                                                ->label('Top text (AM)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.after_slider_block.bottom_text_am')
                                                ->label('Bottom text (AM)')
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('RU')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.after_slider_block.title_ru')
                                                ->label('Title (RU)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.after_slider_block.top_text_ru')
                                                ->label('Top text (RU)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.after_slider_block.bottom_text_ru')
                                                ->label('Bottom text (RU)')
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('EN')
                                        ->schema([
                                            Forms\Components\TextInput::make('content.after_slider_block.title_en')
                                                ->label('Title (EN)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.after_slider_block.top_text_en')
                                                ->label('Top text (EN)')
                                                ->columnSpanFull(),
                                            Forms\Components\RichEditor::make('content.after_slider_block.bottom_text_en')
                                                ->label('Bottom text (EN)')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('content.after_slider_block.video')
                                ->label('Video file (mp4)')
                                ->disk('public')
                                ->directory('pictures-and-videos/video')
                                ->visibility('public')
                                ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                                ->openable()
                                ->downloadable()
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('content.after_slider_block.video_poster')
                                ->label('Video poster image (optional)')
                                ->image()
                                ->disk('public')
                                ->directory('pictures-and-videos/video')
                                ->visibility('public')
                                ->imageEditor()
                                ->imagePreviewHeight('140')
                                ->openable()
                                ->downloadable()
                                ->columnSpanFull(),
                        ])
                        ->collapsed()
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    protected static function photoBlockFields(int $index, string $label): Section
    {
        $base = "items.{$index}";

        return Section::make($label)
            ->collapsed()
            ->schema([
                Forms\Components\Hidden::make("{$base}.id")
                    ->default("photo-{$index}")
                    ->dehydrated(true),

                Forms\Components\Hidden::make("{$base}.type")
                    ->default('photo')
                    ->dehydrated(true),

                Forms\Components\FileUpload::make("{$base}.image")
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('pictures-and-videos/items')
                    ->visibility('public')
                    ->imageEditor()
                    ->imagePreviewHeight('140')
                    ->openable()
                    ->downloadable()
                    ->required(),

                Section::make('Descriptions')
                    ->schema([
                        Forms\Components\RichEditor::make("{$base}.description_am")
                            ->label('Description (AM)'),
                        Forms\Components\RichEditor::make("{$base}.description_ru")
                            ->label('Description (RU)'),
                        Forms\Components\RichEditor::make("{$base}.description_en")
                            ->label('Description (EN)'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function secondBlockItemFields(int $index, string $label): Section
    {
        $base = "content.second_block.items.{$index}";

        return Section::make($label)
            ->collapsed()
            ->schema([
                Forms\Components\Hidden::make("{$base}.id")
                    ->default("block2-{$index}")
                    ->dehydrated(true),

                Forms\Components\Hidden::make("{$base}.type")
                    ->default('photo')
                    ->dehydrated(true),

                Forms\Components\FileUpload::make("{$base}.image")
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('pictures-and-videos/block2')
                    ->visibility('public')
                    ->imageEditor()
                    ->imagePreviewHeight('140')
                    ->openable()
                    ->downloadable()
                    ->required(),

                Section::make('Descriptions')
                    ->schema([
                        Forms\Components\RichEditor::make("{$base}.description_am")
                            ->label('Description (AM)'),
                        Forms\Components\RichEditor::make("{$base}.description_ru")
                            ->label('Description (RU)'),
                        Forms\Components\RichEditor::make("{$base}.description_en")
                            ->label('Description (EN)'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('items')
                    ->label('Items')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' items' : '0 items'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPicturesAndVideos::route('/'),
            'create' => Pages\CreatePicturesAndVideo::route('/create'),
            'edit' => Pages\EditPicturesAndVideo::route('/{record}/edit'),
        ];
    }
}

