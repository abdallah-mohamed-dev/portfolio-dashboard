<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/database.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /dashboard/projects');
    exit;
}
verifyCsrf();

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    header('Location: /dashboard/projects');
    exit;
}

$db = getDB();

function cleanArray(array $arr): array {
    return array_values(array_filter(array_map('trim', $arr)));
}

$data = [
    'id'           => $id,
    'title'        => trim($_POST['title'] ?? ''),
    'type'         => trim($_POST['type'] ?? ''),
    'type_bg'      => trim($_POST['type_bg'] ?? 'rgba(255,255,255,0.1)'),
    'type_color'   => trim($_POST['type_color'] ?? '#ffffff'),
    'short_desc'   => trim($_POST['short_desc'] ?? ''),
    'full_desc'    => trim($_POST['full_desc'] ?? ''),
    'live_url'     => trim($_POST['live_url'] ?? '#'),
    'github_url'   => trim($_POST['github_url'] ?? '#'),
    'sort_order'   => (int)($_POST['sort_order'] ?? 0),
    'stack'        => json_encode(cleanArray($_POST['stack'] ?? [])),
    'stack_colors' => json_encode(cleanArray($_POST['stack_colors'] ?? [])),
    'images'       => json_encode(cleanArray($_POST['images'] ?? [])),
];

if (empty($data['title'])) {
    startSession();
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'عنوان المشروع مطلوب.'];
    header("Location: /dashboard/projects/{$id}/edit");
    exit;
}

$stmt = $db->prepare("
    UPDATE projects SET
        title=:title, type=:type, type_bg=:type_bg, type_color=:type_color,
        short_desc=:short_desc, full_desc=:full_desc,
        live_url=:live_url, github_url=:github_url,
        sort_order=:sort_order, stack=:stack,
        stack_colors=:stack_colors, images=:images
    WHERE id=:id
");
$stmt->execute($data);

startSession();
$_SESSION['flash'] = ['type' => 'success', 'message' => 'تم تحديث المشروع بنجاح ✓'];
header('Location: /dashboard/projects');
exit;
