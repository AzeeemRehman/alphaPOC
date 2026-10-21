<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\DB;
use App\Core\Html;
use App\Core\Uploader;
use App\Core\Validator;
use App\Models\Category;
use App\Models\Post;

final class PostController
{
    public function index(): string
    {
        return view('admin/posts/index', ['title' => 'Blog Posts', 'posts' => Post::allForAdmin()], 'layouts/admin');
    }

    public function create(): string
    {
        return view('admin/posts/form', [
            'title' => 'New Post', 'post' => null, 'categories' => Category::all(),
        ], 'layouts/admin');
    }

    public function store(): void
    {
        [$data, $errors, $image] = $this->collect(null);
        if ($errors) {
            back_with_errors($errors, '/admin/posts/create');
        }
        $data['featured_image'] = $image;
        $data['author_id'] = (int) auth_user()['id'];
        $data['slug'] = Post::uniqueSlug($data['slug']);
        $id = DB::insert('posts', $data);
        flash('success', $data['status'] === 'published' ? 'Post published.' : 'Draft saved.');
        redirect('/admin/posts/' . $id . '/edit');
    }

    public function edit(string $id): string
    {
        $post = Post::find((int) $id);
        if (!$post) {
            abort(404);
        }
        return view('admin/posts/form', [
            'title' => 'Edit Post', 'post' => $post, 'categories' => Category::all(),
        ], 'layouts/admin');
    }

    public function update(string $id): void
    {
        $post = Post::find((int) $id);
        if (!$post) {
            abort(404);
        }
        [$data, $errors, $image] = $this->collect($post);
        if ($errors) {
            back_with_errors($errors, '/admin/posts/' . $id . '/edit');
        }
        if ($image !== null) {
            Uploader::delete($post['featured_image']);
            $data['featured_image'] = $image;
        } elseif (!empty($_POST['remove_image'])) {
            Uploader::delete($post['featured_image']);
            $data['featured_image'] = null;
        }
        $data['slug'] = Post::uniqueSlug($data['slug'], (int) $id);
        DB::update('posts', $data, (int) $id);
        flash('success', 'Post updated.');
        redirect('/admin/posts/' . $id . '/edit');
    }

    public function destroy(string $id): void
    {
        $post = Post::find((int) $id);
        if ($post) {
            Uploader::delete($post['featured_image']);
            Post::delete((int) $id);
            flash('success', 'Post deleted.');
        }
        redirect('/admin/posts');
    }

    /** @return array{0: array, 1: array, 2: ?string} */
    private function collect(?array $existing): array
    {
        $raw = [
            'title'            => (string) input('title', ''),
            'slug'             => (string) input('slug', ''),
            'excerpt'          => (string) input('excerpt', ''),
            'content'          => (string) ($_POST['content'] ?? ''),
            'category_id'      => (string) input('category_id', ''),
            'status'           => (string) input('status', 'draft'),
            'meta_title'       => (string) input('meta_title', ''),
            'meta_description' => (string) input('meta_description', ''),
            'published_at'     => (string) input('published_at', ''),
        ];
        $errors = Validator::make($raw, [
            'title'            => 'required|max:200',
            'slug'             => 'max:200',
            'excerpt'          => 'max:400',
            'status'           => 'required|in:draft,published',
            'meta_title'       => 'max:70',
            'meta_description' => 'max:170',
            'published_at'     => 'date',
        ]);

        $content = Html::clean($raw['content']);
        if ($content === '' || trim(strip_tags($content)) === '' && !str_contains($content, '<img')) {
            $errors['content'] = 'Content is required.';
        }

        [$image, $imageError] = Uploader::image('featured_image');
        if ($imageError) {
            $errors['featured_image'] = $imageError;
        }

        $publishedAt = $raw['published_at'] !== '' ? date('Y-m-d H:i:s', strtotime($raw['published_at'])) : null;
        if ($raw['status'] === 'published' && $publishedAt === null) {
            $publishedAt = $existing['published_at'] ?? date('Y-m-d H:i:s');
        }

        $data = [
            'title'            => $raw['title'],
            'slug'             => slugify($raw['slug'] !== '' ? $raw['slug'] : $raw['title']),
            'excerpt'          => $raw['excerpt'] !== '' ? $raw['excerpt'] : null,
            'content'          => $content,
            'category_id'      => $raw['category_id'] !== '' ? (int) $raw['category_id'] : null,
            'status'           => $raw['status'],
            'meta_title'       => $raw['meta_title'] !== '' ? $raw['meta_title'] : null,
            'meta_description' => $raw['meta_description'] !== '' ? $raw['meta_description'] : null,
            'published_at'     => $publishedAt,
        ];
        return [$data, $errors, $image];
    }
}
