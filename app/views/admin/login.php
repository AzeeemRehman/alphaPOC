<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Sign In | ALPHA GSL</title>
    <link rel="icon" type="image/png" href="<?= asset('assets/img/favicon.png') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?= asset('assets/css/app.css') ?>">
</head>
<body class="flex min-h-screen items-center justify-center bg-navy-900 p-4">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <img src="<?= asset('assets/img/logo-mark.png') ?>" alt="ALPHA GSL" class="mx-auto h-16 rounded-xl bg-white p-2">
            <h1 class="mt-4 text-2xl font-extrabold text-white">Admin Sign In</h1>
        </div>
        <div class="card p-8">
            <?php partial('partials/flash') ?>
            <form method="post" action="<?= url('admin/login') ?>" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="<?= e(old('email')) ?>" required autofocus autocomplete="username" class="form-input">
                </div>
                <div>
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="form-input">
                </div>
                <button type="submit" class="btn-blue w-full">Sign in</button>
            </form>
        </div>
        <p class="mt-4 text-center text-sm text-slate-400"><a href="<?= url('/') ?>" class="hover:text-white">← Back to website</a></p>
    </div>
</body>
</html>
