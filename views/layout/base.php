<?php
// Helpers available in all views
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Dashboard') ?> — Portfolio Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#f0f9ff',
                            100: '#e0f2fe',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        dark: {
                            800: '#1e293b',
                            850: '#172033',
                            900: '#0f172a',
                            950: '#090f1d',
                        }
                    },
                    fontFamily: {
                        sans: ['Cairo', 'Tajawal', 'ui-sans-serif', 'system-ui'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', 'Tajawal', sans-serif; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all duration-200; }
        .sidebar-link.active { @apply bg-brand-500/20 text-brand-400 font-semibold; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
    </style>
</head>
<body class="bg-dark-950 text-white min-h-screen">
<div class="flex min-h-screen">
    <?php if (isLoggedIn()): ?>
        <?php require __DIR__ . '/sidebar.php'; ?>
    <?php endif; ?>
    <div class="flex-1 flex flex-col min-w-0">
        <?php if (isLoggedIn()): ?>
            <?php require __DIR__ . '/header.php'; ?>
        <?php endif; ?>
        <main class="flex-1 p-6 overflow-auto">
            <?php echo $content ?? ''; ?>
        </main>
    </div>
</div>
<script>
    // Flash message auto-dismiss
    const flash = document.getElementById('flash-msg');
    if (flash) { setTimeout(() => flash.remove(), 4000); }
</script>
</body>
</html>
