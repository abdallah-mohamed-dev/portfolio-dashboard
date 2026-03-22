<?php
require_once __DIR__ . '/../../config/auth.php';

if (isLoggedIn()) {
    header('Location: /dashboard/projects');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (attemptLogin($username, $password)) {
        header('Location: /dashboard/projects');
        exit;
    }
    $error = 'اسم المستخدم أو كلمة المرور غير صحيحة.';
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول — Portfolio Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Cairo', 'ui-sans-serif'] } } }
        }
    </script>
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4">

<!-- Background glow -->
<div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-96 h-96 bg-sky-600/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-violet-600/10 rounded-full blur-3xl"></div>
</div>

<div class="relative w-full max-w-sm">
    <!-- Card -->
    <div class="bg-slate-900 border border-white/10 rounded-2xl p-8 shadow-2xl">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-700 flex items-center justify-center text-white font-bold text-2xl mx-auto mb-3 shadow-lg shadow-sky-500/20">A</div>
            <h1 class="text-xl font-bold text-white">Portfolio Admin</h1>
            <p class="text-slate-400 text-sm mt-1">سجّل دخولك للمتابعة</p>
        </div>

        <!-- Error Alert -->
        <?php if ($error): ?>
            <div class="mb-4 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm text-center">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" action="/login" class="space-y-4">
            <div>
                <label class="block text-sm text-slate-300 font-medium mb-1.5" for="username">اسم المستخدم</label>
                <input id="username" name="username" type="text" required
                       value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500
                              focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500/50 transition-all text-sm"
                       placeholder="admin">
            </div>
            <div>
                <label class="block text-sm text-slate-300 font-medium mb-1.5" for="password">كلمة المرور</label>
                <input id="password" name="password" type="password" required
                       class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500
                              focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500/50 transition-all text-sm"
                       placeholder="••••••••">
            </div>
            <button type="submit"
                    class="w-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500
                           text-white font-semibold py-2.5 rounded-xl transition-all duration-200
                           shadow-lg shadow-sky-500/20 hover:shadow-sky-500/30 transform hover:scale-[1.01] mt-2">
                دخول
            </button>
        </form>
    </div>
</div>
</body>
</html>
