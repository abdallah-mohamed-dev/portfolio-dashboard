<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/database.php';
requireLogin();

// Get id from URL: /dashboard/projects/{id}/edit
$parts = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
// Expected: ['dashboard','projects','{id}','edit']
$id = isset($parts[2]) ? (int)$parts[2] : 0;

$db = getDB();
$project = $db->prepare("SELECT * FROM projects WHERE id = ?")->execute([$id]) ? null : null;
$stmt = $db->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    startSession();
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'المشروع غير موجود.'];
    header('Location: /dashboard/projects');
    exit;
}

ob_start();
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
            <h2 class="text-2xl font-bold text-white">تعديل المشروع</h2>
            <p class="text-slate-400 text-sm"><?= htmlspecialchars($project['title'], ENT_QUOTES) ?></p>
        </div>
    </div>

    <form method="POST" action="/dashboard/projects/update" class="space-y-5">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES) ?>">
        <input type="hidden" name="id" value="<?= (int)$project['id'] ?>">

        <?php require __DIR__ . '/form_fields.php'; ?>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="flex-1 bg-sky-500 hover:bg-sky-400 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-sky-500/20">
                حفظ التعديلات
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
$pageTitle = 'تعديل المشروع';
require __DIR__ . '/../../views/layout/base.php';
