<?php
/**
 * Main Entry Router
 * Handles all incoming requests and dispatches to the correct handler.
 *
 * URL Map:
 *   GET  /                              → redirect to /dashboard/projects
 *   GET  /login                         → auth/login.php
 *   POST /login                         → auth/login.php
 *   GET  /logout                        → auth/logout.php
 *   GET  /api/*                         → api/router.php
 *   GET  /dashboard/projects            → modules/projects/list.php
 *   GET  /dashboard/projects/create     → modules/projects/create.php
 *   POST /dashboard/projects/store      → modules/projects/store.php
 *   GET  /dashboard/projects/{id}/edit  → modules/projects/edit.php
 *   POST /dashboard/projects/update     → modules/projects/update.php
 *   POST /dashboard/projects/delete     → modules/projects/delete.php
 *
 * To add a new module (e.g. skills):
 *   1. Create modules/skills/ with list/create/edit/store/update/delete.php
 *   2. Add routes below tagged with "── skills ──"
 *   3. Create api/skills/index.php and add to api/router.php
 */

require_once __DIR__ . '/config/auth.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri    = rtrim($uri, '/') ?: '/';

// ─── Root redirect ────────────────────────────────────────────────────────────
if ($uri === '') $uri = '/';
if ($uri === '/') {
    header('Location: /dashboard/projects');
    exit;
}

// ─── API ──────────────────────────────────────────────────────────────────────
if (str_starts_with($uri, '/api/')) {
    require __DIR__ . '/api/router.php';
    exit;
}

// ─── Auth ─────────────────────────────────────────────────────────────────────
if ($uri === '/login') {
    require __DIR__ . '/modules/auth/login.php';
    exit;
}
if ($uri === '/logout') {
    require __DIR__ . '/modules/auth/logout.php';
    exit;
}

// ─── Projects ─────────────────────────────────────────────────────────────────
if ($uri === '/dashboard/projects') {
    require __DIR__ . '/modules/projects/list.php';
    exit;
}
if ($uri === '/dashboard/projects/create') {
    require __DIR__ . '/modules/projects/create.php';
    exit;
}
if ($uri === '/dashboard/projects/store' && $method === 'POST') {
    require __DIR__ . '/modules/projects/store.php';
    exit;
}
if ($uri === '/dashboard/projects/update' && $method === 'POST') {
    require __DIR__ . '/modules/projects/update.php';
    exit;
}
if ($uri === '/dashboard/projects/delete' && $method === 'POST') {
    require __DIR__ . '/modules/projects/delete.php';
    exit;
}
// /dashboard/projects/{id}/edit
if (preg_match('#^/dashboard/projects/(\d+)/edit$#', $uri)) {
    require __DIR__ . '/modules/projects/edit.php';
    exit;
}

// ─── Add new modules here ─────────────────────────────────────────────────────
// ── skills ──
// if ($uri === '/dashboard/skills')                               { require __DIR__ . '/modules/skills/list.php';   exit; }
// if ($uri === '/dashboard/skills/create')                        { require __DIR__ . '/modules/skills/create.php'; exit; }
// if ($uri === '/dashboard/skills/store'   && $method === 'POST') { require __DIR__ . '/modules/skills/store.php';  exit; }
// ...
// ─────────────────────────────────────────────────────────────────────────────

// ─── 404 ──────────────────────────────────────────────────────────────────────
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>404 — غير موجود</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center text-center p-4">
    <div>
        <p class="text-8xl font-bold text-slate-700 mb-4">404</p>
        <h1 class="text-xl font-semibold text-white mb-2">الصفحة غير موجودة</h1>
        <a href="/dashboard/projects" class="text-sky-400 hover:text-sky-300 transition-colors text-sm">← العودة للوحة التحكم</a>
    </div>
</body>
</html>
