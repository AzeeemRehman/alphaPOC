<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Validator;
use App\Models\Setting;

final class SettingController
{
    public function index(): string
    {
        return view('admin/settings', ['title' => 'Site Settings', 'values' => Setting::all()], 'layouts/admin');
    }

    public function update(): void
    {
        $values = [];
        foreach (array_keys(Setting::DEFAULTS) as $key) {
            $values[$key] = trim((string) ($_POST[$key] ?? ''));
        }
        $errors = Validator::make($values, [
            'company_name' => 'required|max:150', 'phone' => 'required|max:40', 'mobile' => 'required|max:40',
            'whatsapp' => 'required|max:20', 'email' => 'required|email', 'notify_email' => 'required|email',
            'address' => 'required|max:300', 'hours' => 'max:100', 'tagline' => 'max:100',
            'facebook' => 'url', 'linkedin' => 'url', 'instagram' => 'url', 'map_embed' => 'url',
        ]);
        if ($errors) {
            back_with_errors($errors, '/admin/settings');
        }
        Setting::save($values);
        flash('success', 'Settings saved.');
        redirect('/admin/settings');
    }
}
