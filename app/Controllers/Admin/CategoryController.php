<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Validator;
use App\Models\Category;

final class CategoryController
{
    public function index(): string
    {
        return view('admin/categories', ['title' => 'Categories', 'categories' => Category::withCounts()], 'layouts/admin');
    }

    public function store(): void
    {
        $name = (string) input('name', '');
        $errors = Validator::make(['name' => $name], ['name' => 'required|max:100']);
        if ($errors) {
            back_with_errors($errors, '/admin/categories');
        }
        Category::create($name);
        flash('success', 'Category added.');
        redirect('/admin/categories');
    }

    public function destroy(string $id): void
    {
        Category::delete((int) $id);
        flash('success', 'Category deleted. Its posts are now uncategorised.');
        redirect('/admin/categories');
    }
}
