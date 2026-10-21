<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Models\Query;
use App\Models\Shipment;

final class DashboardController
{
    public function index(): string
    {
        return view('admin/dashboard', [
            'title'     => 'Dashboard',
            'newCount'  => Query::count('new'),
            'queryTotal' => Query::count(),
            'postCount' => Post::count(),
            'draftCount' => Post::count('draft'),
            'shipCount' => Shipment::count(),
            'recent'    => Query::recent(6),
        ], 'layouts/admin');
    }
}
