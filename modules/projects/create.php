<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/database.php';
requireLogin();

ob_start();
$errors = [];

// Handle POST from store.php — just show blank form here
?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="/dashboard/projects"
           class="text-slate-400 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-white">إضافة مشروع جديد</h2>
            <p class="text-slate-400 text-sm">أضف بيانات المشروع وسيظهر في الـ API تلقائياً</p>
        </div>
    </div>

    <form method="POST" action="/dashboard/projects/store" class="space-y-5">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES) ?>">

        <?php require __DIR__ . '/form_fields.php'; ?>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="flex-1 bg-sky-500 hover:bg-sky-400 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-sky-500/20">
                حفظ المشروع
            </button>
            <a href="/dashboard/projects"
               class="px-6 py-3 bg-white/5 hover:bg-white/10 text-slate-300 rounded-xl transition-all font-medium">
                إلغاء
            </a>
        </div>
    </form>
</div>
<?php
$content   = ob_get_clean();
$pageTitle = 'إضافة مشروع';
require __DIR__ . '/../../views/layout/base.php';
