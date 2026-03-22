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
if ($id) {
    $db = getDB();
    $db->prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);
    startSession();
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'تم حذف المشروع بنجاح.'];
}

header('Location: /dashboard/projects');
exit;
