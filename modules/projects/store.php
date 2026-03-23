<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/database.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/projects');
    exit;
}
verifyCsrf();

$db = getDB();

function cleanArray(array $arr): array {
    return array_values(array_filter(array_map('trim', $arr)));
}

$data = [
    'title'        => trim($_POST['title'] ?? ''),
    'type'         => trim($_POST['type'] ?? ''),
    'type_bg'      => trim($_POST['type_bg'] ?? 'rgba(255,255,255,0.1)'),
    'type_color'   => trim($_POST['type_color'] ?? '#ffffff'),
    'short_desc'   => trim($_POST['short_desc'] ?? ''),
    'full_desc'    => trim($_POST['full_desc'] ?? ''),
    'live_url'     => trim($_POST['live_url'] ?? '#'),
    'github_url'   => trim($_POST['github_url'] ?? '#'),
    'figma_url'    => trim($_POST['figma_url'] ?? '#'),
    'sort_order'   => (int)($_POST['sort_order'] ?? 0),
    'stack'        => json_encode(cleanArray($_POST['stack'] ?? [])),
    'stack_colors' => json_encode(cleanArray($_POST['stack_colors'] ?? [])),
    'images'       => json_encode(cleanArray($_POST['images'] ?? [])),
];

if (empty($data['title'])) {
    startSession();
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'عنوان المشروع مطلوب.'];
    header('Location: /dashboard/projects/create');
    exit;
}

$stmt = $db->prepare("
    INSERT INTO projects (title, type, type_bg, type_color, short_desc, full_desc, stack, stack_colors, images, live_url, github_url, figma_url, sort_order)
    VALUES (:title, :type, :type_bg, :type_color, :short_desc, :full_desc, :stack, :stack_colors, :images, :live_url, :github_url, :figma_url, :sort_order)
");
$stmt->execute($data);

startSession();
$_SESSION['flash'] = ['type' => 'success', 'message' => 'تم إضافة المشروع بنجاح ✓'];
header('Location: /dashboard/projects');
exit;
