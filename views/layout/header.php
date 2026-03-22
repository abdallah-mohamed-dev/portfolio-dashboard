<?php
$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts  = explode('/', trim($path, '/'));

$breadcrumbs = ['' => 'الرئيسية'];
if (isset($parts[1])) $breadcrumbs[$parts[1]] = ucfirst($parts[1]);
if (isset($parts[2])) $breadcrumbs[$parts[2]] = $pageTitle ?? ucfirst($parts[2]);
?>
<header class="h-14 bg-dark-900/50 border-b border-white/5 flex items-center px-6 gap-4 sticky top-0 z-10 backdrop-blur-md">
    <!-- Breadcrumb -->
    <div class="flex-1 flex items-center gap-2 text-sm text-slate-400">
        <a href="/dashboard/projects" class="hover:text-white transition-colors">الرئيسية</a>
        <?php if (isset($pageTitle)): ?>
            <span class="text-slate-600">/</span>
            <span class="text-white font-medium"><?= e($pageTitle) ?></span>
        <?php endif; ?>
    </div>

    <!-- Flash Message -->
    <?php
    startSession();
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    ?>
    <?php if ($flash): ?>
        <div id="flash-msg"
             class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all
                    <?= $flash['type'] === 'success'
                        ? 'bg-green-500/20 text-green-400 border border-green-500/30'
                        : 'bg-red-500/20 text-red-400 border border-red-500/30'
                    ?>">
            <?= e($flash['message']) ?>
        </div>
    <?php endif; ?>
</header>
