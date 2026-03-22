<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/database.php';
requireLogin();

$db       = getDB();
$projects = $db->query("SELECT * FROM projects ORDER BY sort_order ASC, id ASC")->fetchAll();

ob_start();
?>
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white">المشاريع</h2>
            <p class="text-slate-400 text-sm mt-1"><?= count($projects) ?> مشروع مسجّل</p>
        </div>
        <a href="/dashboard/projects/create"
           class="flex items-center gap-2 bg-sky-500 hover:bg-sky-400 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-sky-500/20 hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة مشروع
        </a>
    </div>

    <?php if (empty($projects)): ?>
        <!-- Empty State -->
        <div class="bg-slate-900/50 border border-white/5 rounded-2xl flex flex-col items-center justify-center py-20 text-center">
            <div class="text-5xl mb-4">📁</div>
            <h3 class="text-white font-semibold text-lg mb-2">لا توجد مشاريع بعد</h3>
            <p class="text-slate-400 text-sm mb-6">ابدأ بإضافة مشروعك الأول</p>
            <a href="/dashboard/projects/create"
               class="bg-sky-500 hover:bg-sky-400 text-white px-6 py-2.5 rounded-xl font-medium transition-all">
                إضافة مشروع
            </a>
        </div>
    <?php else: ?>
        <!-- Projects Grid -->
        <div class="grid gap-4">
            <?php foreach ($projects as $p): ?>
                <?php
                    $stack  = json_decode($p['stack'], true) ?: [];
                    $images = json_decode($p['images'], true) ?: [];
                    $thumb  = $images[0] ?? null;
                ?>
                <div class="group bg-slate-900 border border-white/5 rounded-2xl p-5 flex items-center gap-5 hover:border-sky-500/30 transition-all duration-200">
                    <!-- Thumb -->
                    <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 bg-slate-800">
                        <?php if ($thumb): ?>
                            <img src="<?= htmlspecialchars($thumb, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($p['title'], ENT_QUOTES) ?>"
                                 class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-2xl">📷</div>
                        <?php endif; ?>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-white text-base truncate"><?= htmlspecialchars($p['title'], ENT_QUOTES) ?></h3>
                            <span class="text-xs px-2.5 py-0.5 rounded-full font-medium shrink-0"
                                  style="background:<?= htmlspecialchars($p['type_bg'], ENT_QUOTES) ?>; color:<?= htmlspecialchars($p['type_color'], ENT_QUOTES) ?>">
                                <?= htmlspecialchars($p['type'], ENT_QUOTES) ?>
                            </span>
                        </div>
                        <p class="text-slate-400 text-sm truncate mb-2"><?= htmlspecialchars($p['short_desc'], ENT_QUOTES) ?></p>
                        <!-- Stack Tags -->
                        <div class="flex flex-wrap gap-1.5">
                            <?php foreach (array_slice($stack, 0, 5) as $tag): ?>
                                <span class="text-xs px-2 py-0.5 bg-white/5 text-slate-300 rounded-md">
                                    <?= htmlspecialchars($tag, ENT_QUOTES) ?>
                                </span>
                            <?php endforeach; ?>
                            <?php if (count($stack) > 5): ?>
                                <span class="text-xs px-2 py-0.5 bg-white/5 text-slate-400 rounded-md">+<?= count($stack) - 5 ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sort Order  -->
                    <div class="text-center shrink-0 hidden sm:block">
                        <span class="text-xs text-slate-500">ترتيب</span>
                        <p class="text-white font-bold"><?= (int)$p['sort_order'] ?></p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="/dashboard/projects/<?= (int)$p['id'] ?>/edit"
                           class="px-3 py-1.5 bg-white/5 hover:bg-sky-500/20 hover:text-sky-400 text-slate-300 rounded-lg text-sm transition-all flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            تعديل
                        </a>
                        <form method="POST" action="/dashboard/projects/delete" onsubmit="return confirm('هل أنت متأكد من حذف هذا المشروع؟')">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES) ?>">
                            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                            <button type="submit"
                                    class="px-3 py-1.5 bg-white/5 hover:bg-red-500/20 hover:text-red-400 text-slate-300 rounded-lg text-sm transition-all flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php
$content   = ob_get_clean();
$pageTitle = 'المشاريع';
require __DIR__ . '/../../views/layout/base.php';
