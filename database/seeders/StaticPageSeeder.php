<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        StaticPage::updateOrCreate(
            ['slug' => 'gallery'],
            [
                'title' => 'Gallery Page',
                'is_active' => true,

                'content_am' => [
                    'hero' => [
                        'title' => 'Art Gallery',
                        'subtitle' => 'Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs',
                    ],
                    'bottom_feature_section' => [
                        'title' => 'GALLERY',
                        'items' => [
                            '<p>Առաջին տեքստը այստեղ։ Կարող ես փոխել սա ադմինից։</p>',
                            '<p>Երկրորդ տեքստը այստեղ։ Սա նույնպես կփոխես ադմինից։</p>',
                            '<p>Երրորդ տեքստը այստեղ։</p>',
                        ],
                        'image' => 'static/gallery/bottom-feature.jpg',
                        'button_link' => '/gallery',
                    ],
                ],

                'content_ru' => [
                    'hero' => [
                        'title' => 'Art Gallery',
                        'subtitle' => 'Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs',
                    ],
                    'bottom_feature_section' => [
                        'title' => 'GALLERY',
                        'items' => [
                            '<p>Первый текст здесь. Его можно менять из админки.</p>',
                            '<p>Второй текст здесь. Его тоже можно менять.</p>',
                            '<p>Третий текст здесь.</p>',
                        ],
                        'image' => 'static/gallery/bottom-feature.jpg',
                        'button_link' => '/gallery',
                    ],
                ],

                'content_en' => [
                    'hero' => [
                        'title' => 'Art Gallery',
                        'subtitle' => 'Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs',
                    ],
                    'bottom_feature_section' => [
                        'title' => 'GALLERY',
                        'items' => [
                            '<p>Lorem ipsum is simply dummy text of the printing and typesetting industry.</p>',
                            '<p>Lorem ipsum has been the industry standard dummy text ever since the 1500s.</p>',
                            '<p>Lorem ipsum has survived not only five centuries, but also the leap into electronic typesetting.</p>',
                        ],
                        'image' => 'static/gallery/bottom-feature.jpg',
                        'button_link' => '/gallery',
                    ],
                ],
            ]
        );

        StaticPage::updateOrCreate(
            ['slug' => 'footer'],
            [
                'title' => 'Footer',
                'is_active' => true,

                'content_am' => [
                    'top_text' => 'Lorem Ipsum is simply dummy text',
                    'menu' => [
                        ['label' => 'ABOUT ME', 'url' => '/about'],
                        ['label' => 'GALLERY', 'url' => '/gallery'],
                        ['label' => 'EXHIBITIONS', 'url' => '/exhibitions'],
                        ['label' => 'ARTICLES', 'url' => '/articles'],
                        ['label' => 'PICTURES AND VIDEOS', 'url' => '/pictures-and-videos'],
                        ['label' => 'COLLECTION', 'url' => '/collection'],
                        ['label' => 'CONTACT ME', 'url' => '/contact'],
                    ],
                ],

                'content_ru' => [
                    'top_text' => 'Lorem Ipsum is simply dummy text',
                    'menu' => [
                        ['label' => 'ABOUT ME', 'url' => '/about'],
                        ['label' => 'GALLERY', 'url' => '/gallery'],
                        ['label' => 'EXHIBITIONS', 'url' => '/exhibitions'],
                        ['label' => 'ARTICLES', 'url' => '/articles'],
                        ['label' => 'PICTURES AND VIDEOS', 'url' => '/pictures-and-videos'],
                        ['label' => 'COLLECTION', 'url' => '/collection'],
                        ['label' => 'CONTACT ME', 'url' => '/contact'],
                    ],
                ],

                'content_en' => [
                    'top_text' => 'Lorem Ipsum is simply dummy text',
                    'menu' => [
                        ['label' => 'ABOUT ME', 'url' => '/about'],
                        ['label' => 'GALLERY', 'url' => '/gallery'],
                        ['label' => 'EXHIBITIONS', 'url' => '/exhibitions'],
                        ['label' => 'ARTICLES', 'url' => '/articles'],
                        ['label' => 'PICTURES AND VIDEOS', 'url' => '/pictures-and-videos'],
                        ['label' => 'COLLECTION', 'url' => '/collection'],
                        ['label' => 'CONTACT ME', 'url' => '/contact'],
                    ],
                ],
            ]
        );
        StaticPage::updateOrCreate(
            ['slug' => 'header'],
            [
                'title' => 'Header',
                'is_active' => true,

                'content_am' => [
                    'top_text' => 'Լորեմ Իպսում տեքստ',
                    'menu' => [
                        ['label' => 'ԻՄ ՄԱՍԻՆ', 'url' => '/about'],
                        ['label' => 'ՊԱՏԿԵՐԱՍՐԱՀ', 'url' => '/gallery'],
                        ['label' => 'ՑՈՒՑԱՀԱՆԴԵՍՆԵՐ', 'url' => '/exhibitions'],
                        ['label' => 'ՀՈԴՎԱԾՆԵՐ', 'url' => '/articles'],
                        ['label' => 'ՆԿԱՐՆԵՐ ԵՎ ՏԵՍԱՆՅՈՒԹԵՐ', 'url' => '/pictures-and-videos'],
                        ['label' => 'ՀԱՎԱՔԱԾՈՒ', 'url' => '/collection'],
                        ['label' => 'ԿԱՊ', 'url' => '/contact'],
                    ],
                ],

                'content_ru' => [
                    'top_text' => 'Lorem Ipsum просто текст',
                    'menu' => [
                        ['label' => 'ОБО МНЕ', 'url' => '/about'],
                        ['label' => 'ГАЛЕРЕЯ', 'url' => '/gallery'],
                        ['label' => 'ВЫСТАВКИ', 'url' => '/exhibitions'],
                        ['label' => 'СТАТЬИ', 'url' => '/articles'],
                        ['label' => 'ФОТО И ВИДЕО', 'url' => '/pictures-and-videos'],
                        ['label' => 'КОЛЛЕКЦИЯ', 'url' => '/collection'],
                        ['label' => 'КОНТАКТЫ', 'url' => '/contact'],
                    ],
                ],

                'content_en' => [
                    'top_text' => 'Lorem Ipsum is simply dummy text',
                    'menu' => [
                        ['label' => 'ABOUT ME', 'url' => '/about'],
                        ['label' => 'GALLERY', 'url' => '/gallery'],
                        ['label' => 'EXHIBITIONS', 'url' => '/exhibitions'],
                        ['label' => 'ARTICLES', 'url' => '/articles'],
                        ['label' => 'PICTURES AND VIDEOS', 'url' => '/pictures-and-videos'],
                        ['label' => 'COLLECTION', 'url' => '/collection'],
                        ['label' => 'CONTACT ME', 'url' => '/contact'],
                    ],
                ],
            ]
        );
    }
}
