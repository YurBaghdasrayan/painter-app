<?php

namespace Database\Seeders;

use App\Models\PicturesAndVideo;
use Illuminate\Database\Seeder;

class PicturesAndVideosSeeder extends Seeder
{
    public function run(): void
    {
        PicturesAndVideo::updateOrCreate(
            ['id' => 1],
            [
                'is_active' => true,
                'sort_order' => 0,
                'items' => [
                    ['id' => 'photo-0', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                    ['id' => 'photo-1', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                    ['id' => 'photo-2', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                    ['id' => 'photo-3', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                    ['id' => 'photo-4', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                ],
                'content' => [
                    'second_block' => [
                        'title_am' => 'LOREM IPSUM',
                        'title_ru' => 'LOREM IPSUM',
                        'title_en' => 'LOREM IPSUM',
                        'text_am' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'text_ru' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'text_en' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_text_am' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_text_ru' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_text_en' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'video' => null,
                        'video_poster' => null,
                        'items' => [
                            ['id' => 'block2-0', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                            ['id' => 'block2-1', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                            ['id' => 'block2-2', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                            ['id' => 'block2-3', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                            ['id' => 'block2-4', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                            ['id' => 'block2-5', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                            ['id' => 'block2-6', 'type' => 'photo', 'image' => null, 'description_am' => null, 'description_ru' => null, 'description_en' => null],
                        ],
                    ],
                    'third_block' => [
                        'title_am' => 'LOREM IPSUM',
                        'title_ru' => 'LOREM IPSUM',
                        'title_en' => 'LOREM IPSUM',
                        'top_left_text_am' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'top_left_text_ru' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'top_left_text_en' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'top_right_text_am' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'top_right_text_ru' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'top_right_text_en' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_left_text_am' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_left_text_ru' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_left_text_en' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_right_text_am' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_right_text_ru' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_right_text_en' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'left_video' => null,
                        'left_video_poster' => null,
                        'right_video' => null,
                        'right_video_poster' => null,
                    ],
                    'fourth_block' => [
                        'arrow_label' => null,
                        'items' => [
                            ['id' => 'slider-0', 'type' => 'slide', 'image' => null, 'title_am' => 'GALLERY', 'title_ru' => 'GALLERY', 'title_en' => 'GALLERY', 'text_am' => null, 'text_ru' => null, 'text_en' => null],
                            ['id' => 'slider-1', 'type' => 'slide', 'image' => null, 'title_am' => 'GALLERY', 'title_ru' => 'GALLERY', 'title_en' => 'GALLERY', 'text_am' => null, 'text_ru' => null, 'text_en' => null],
                            ['id' => 'slider-2', 'type' => 'slide', 'image' => null, 'title_am' => 'GALLERY', 'title_ru' => 'GALLERY', 'title_en' => 'GALLERY', 'text_am' => null, 'text_ru' => null, 'text_en' => null],
                            ['id' => 'slider-3', 'type' => 'slide', 'image' => null, 'title_am' => 'GALLERY', 'title_ru' => 'GALLERY', 'title_en' => 'GALLERY', 'text_am' => null, 'text_ru' => null, 'text_en' => null],
                            ['id' => 'slider-4', 'type' => 'slide', 'image' => null, 'title_am' => 'GALLERY', 'title_ru' => 'GALLERY', 'title_en' => 'GALLERY', 'text_am' => null, 'text_ru' => null, 'text_en' => null],
                            ['id' => 'slider-5', 'type' => 'slide', 'image' => null, 'title_am' => 'GALLERY', 'title_ru' => 'GALLERY', 'title_en' => 'GALLERY', 'text_am' => null, 'text_ru' => null, 'text_en' => null],
                            ['id' => 'slider-6', 'type' => 'slide', 'image' => null, 'title_am' => 'GALLERY', 'title_ru' => 'GALLERY', 'title_en' => 'GALLERY', 'text_am' => null, 'text_ru' => null, 'text_en' => null],
                            ['id' => 'slider-7', 'type' => 'slide', 'image' => null, 'title_am' => 'GALLERY', 'title_ru' => 'GALLERY', 'title_en' => 'GALLERY', 'text_am' => null, 'text_ru' => null, 'text_en' => null],
                        ],
                    ],
                    'after_slider_block' => [
                        'title_am' => 'LOREM IPSUM',
                        'title_ru' => 'LOREM IPSUM',
                        'title_en' => 'LOREM IPSUM',
                        'top_text_am' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'top_text_ru' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'top_text_en' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_text_am' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale. We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_text_ru' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale. We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'bottom_text_en' => 'We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale. We help businesses to lead the charge to digital innovation and tap into the power of the AI, by transforming and creating a competitive advantage that will scale.',
                        'video' => null,
                        'video_poster' => null,
                    ],
                ],
            ]
        );
    }
}

