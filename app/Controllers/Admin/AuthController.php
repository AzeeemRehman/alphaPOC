<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Validator;
use App\Models\User;

final class AuthController
{
    public function showLogin(): string
    {
        return view('admin/login', ['title' => 'Admin Sign In'], null);
    }

    public function login(): void
    {
        $email = strtolower((string) input('email', ''));
        $password = (string) ($_POST['password'] ?? '');

        if (Auth::isLockedOut($email)) {
            back_with_errors(['_form' => 'Too many failed attempts. Please try again in 15 minutes.'], '/admin/login');
        }
        if (!Auth::attempt($email, $password)) {
            back_with_errors(['_form' => 'Incorrect email or password.'], '/admin/login');
        }
        redirect('/admin');
    }

    public function logout(): void
    {
        Auth::logout();
        redirect('/admin/login');
    }

    public function showAccount(): string
    {
        return view('admin/account', ['title' => 'My Account', 'user' => auth_user()], 'layouts/admin');
    }

    public function updateAccount(): void
    {
        $user = auth_user();
        $current = (string) ($_POST['current_password'] ?? '');
        $new = (string) ($_POST['password'] ?? '');
        $confirm = (string) ($_POST['password_confirmation'] ?? '');

        $errors = [];
        if (!password_verify($current, $user['password_hash'])) {
            $errors['current_password'] = 'Current password is incorrect.';
        }
        if (strlen($new) < 10) {
            $errors['password'] = 'New password must be at least 10 characters.';
        } elseif ($new !== $confirm) {
            $errors['password_confirmation'] = 'Passwords do not match.';
        }
        if ($errors) {
            back_with_errors($errors, '/admin/account');
        }

        User::setPassword((int) $user['id'], $new);
        flash('success', 'Password updated.');
        redirect('/admin/account');
    }

    public function createUser(): void
    {
        $data = ['name' => (string) input('name', ''), 'email' => (string) input('email', ''), 'role' => (string) input('role', 'editor')];
        $password = (string) ($_POST['password'] ?? '');
        $errors = Validator::make($data, ['name' => 'required|max:100', 'email' => 'required|email|max:150', 'role' => 'required|in:admin,editor']);
        if (strlen($password) < 10) {
            $errors['password'] = 'Password must be at least 10 characters.';
        }
        if (!$errors && User::findByEmail($data['email'])) {
            $errors['email'] = 'A user with this email already exists.';
        }
        if ($errors) {
            back_with_errors($errors, '/admin/account');
        }
        User::create($data['name'], $data['email'], $password, $data['role']);
        flash('success', 'User created.');
        redirect('/admin/account');
    }
}
