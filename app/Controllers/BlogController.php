<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;

final class BlogController
{
    public function index(?string $categorySlug = null): string
    {
        $category = null;
        if ($categorySlug !== null) {
            $category = Category::findBySlug($categorySlug);
            if (!$category) {
                abort(404);
            }
        }

        $search = trim((string) ($_GET['q'] ?? ''));
        $search = $search === '' ? null : mb_substr($search, 0, 80);
        $perPage = (int) config('blog.per_page');
        $total = Post::countPublished($categorySlug, $search);
        $pages = max(1, (int) ceil($total / $perPage));
        $page = min(max(1, (int) ($_GET['page'] ?? 1)), $pages);

        return view('blog/index', [
            'title'      => $category ? $category['name'] . ' – Blog' : 'Blog & Shipping News',
            'metaDesc'   => 'Shipping news, freight tips and logistics guides from ALPHA Global Shipping & Logistics.',
            'posts'      => Post::published($page, $perPage, $categorySlug, $search),
            'categories' => Category::withCounts(),
            'recent'     => Post::latest(4),
            'category'   => $category,
            'search'     => $search,
            'page'       => $page,
            'pages'      => $pages,
            'total'      => $total,
        ]);
    }

    public function category(string $slug): string
    {
        return $this->index($slug);
    }

    public function show(string $slug): string
    {
        $post = Post::findPublishedBySlug($slug);
        if (!$post) {
            abort(404);
        }
        return view('blog/show', [
            'title'     => $post['meta_title'] ?: $post['title'],
            'metaDesc'  => $post['meta_description'] ?: ($post['excerpt'] ?: excerpt($post['content'], 155)),
            'ogImage'   => $post['featured_image'] ? absolute_url('uploads/blog/' . $post['featured_image']) : null,
            'ogType'    => 'article',
            'post'      => $post,
            'related'   => Post::related($post),
            'categories' => Category::withCounts(),
        ]);
    }
}
