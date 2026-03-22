<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$navItems = [
    ['icon' => '📁', 'label' => 'المشاريع', 'href' => '/dashboard/projects'],
    // ─── Add new sections here ───────────────────────────────────────────
    // ['icon' => '🛠', 'label' => 'المهارات',  'href' => '/dashboard/skills'],
    // ['icon' => '📬', 'label' => 'الرسائل',   'href' => '/dashboard/messages'],
];
?>
<aside class="w-64 bg-dark-900 border-l border-white/5 flex flex-col shrink-0 min-h-screen">
    <!-- Logo -->
    <div class="px-6 py-5 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white font-bold text-sm">A</div>
            <div>
                <p class="text-sm font-bold text-white leading-tight">Portfolio Admin</p>
                <p class="text-xs text-slate-400">لوحة التحكم</p>
            </div>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <a href="/dashboard/projects"
           class="sidebar-link <?= str_starts_with($currentPath, '/dashboard/projects') ? 'active' : '' ?>">
            <span class="text-lg">📁</span>
            <span>المشاريع</span>
        </a>
        <!-- ─── Future sections auto-appear here ─── -->
    </nav>

    <!-- API Links -->
    <div class="px-3 py-3 border-t border-white/5">
        <p class="text-xs text-slate-500 px-4 mb-2 font-medium">API Endpoints</p>
        <a href="/api/projects" target="_blank"
           class="flex items-center gap-2 px-4 py-2 text-xs text-slate-400 hover:text-brand-400 hover:bg-white/5 rounded-xl transition-all">
            <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span>
            GET /api/projects
        </a>
    </div>

    <!-- User footer -->
    <div class="px-3 py-3 border-t border-white/5">
        <div class="flex items-center gap-3 px-4 py-2.5">
            <div class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center text-xs font-bold">AD</div>
            <div class="flex-1 min-w-0">
                <p class="text-sm text-white font-medium truncate"><?= e($_SESSION['admin_user'] ?? 'Admin') ?></p>
                <p class="text-xs text-slate-400">مدير النظام</p>
            </div>
            <a href="/logout" title="تسجيل الخروج"
               class="text-slate-400 hover:text-red-400 transition-colors p-1 rounded-lg hover:bg-red-400/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                </svg>
            </a>
        </div>
    </div>
</aside>
