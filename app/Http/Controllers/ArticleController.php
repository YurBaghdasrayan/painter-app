<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\StaticPage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articlesPage = StaticPage::query()
            ->where('slug', 'articles')
            ->where('is_active', true)
            ->first();

        $articles = Article::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('articles.index', [
            'articlesPage' => $articlesPage,
            'articles' => $articles,
        ]);
    }

    public function show(string $slug): View
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $content = $article->localizedContent();

        $hero = $content['hero'] ?? [];
        $textBlock1 = $content['text_block_1'] ?? [];
        $imageBlock1 = $content['image_block_1'] ?? [];
        $textBlock2 = $content['text_block_2'] ?? [];
        $imageBlock2 = $content['image_block_2'] ?? [];

        // fallback: если новых ключей нет, берем старые данные
        $afterImage2 = $content['after_image_2'] ?? [
            'left_text' => $imageBlock2['left_text'] ?? '',
            'right_text' => $imageBlock2['right_text'] ?? '',
        ];

        $bottomBlock = $content['bottom_block'] ?? ($content['text_block_3'] ?? []);

        $relatedArticles = Article::query()
            ->where('is_active', true)
            ->where('id', '!=', $article->id)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('articles.show', [
            'article' => $article,
            'content' => $content,
            'hero' => $hero,
            'textBlock1' => $textBlock1,
            'imageBlock1' => $imageBlock1,
            'textBlock2' => $textBlock2,
            'imageBlock2' => $imageBlock2,
            'afterImage2' => $afterImage2,
            'bottomBlock' => $bottomBlock,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
