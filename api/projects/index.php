<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$db = getDB();

// Route: GET /api/projects/{id}  OR  GET /api/projects
$parts = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
// parts[0]=api, parts[1]=projects, parts[2]=optional id

if (isset($parts[2]) && is_numeric($parts[2])) {
    // Single project
    $stmt = $db->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([(int)$parts[2]]);
    $row = $stmt->fetch();
    if (!$row) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Project not found']);
        exit;
    }
    echo json_encode([
        'status' => 'success',
        'data'   => formatProject($row),
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    // All projects
    $rows = $db->query("SELECT * FROM projects ORDER BY sort_order ASC, id ASC")->fetchAll();
    echo json_encode([
        'status' => 'success',
        'data'   => array_map('formatProject', $rows),
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function formatProject(array $row): array {
    return [
        'id'         => (int)$row['id'],
        'title'      => $row['title'],
        'type'       => $row['type'],
        'typeBg'     => $row['type_bg'],
        'typeColor'  => $row['type_color'],
        'shortDesc'  => $row['short_desc'],
        'fullDesc'   => $row['full_desc'],
        'stack'      => json_decode($row['stack'], true) ?: [],
        'stackColors'=> json_decode($row['stack_colors'], true) ?: [],
        'images'     => json_decode($row['images'], true) ?: [],
        'liveUrl'    => $row['live_url'],
        'githubUrl'  => $row['github_url'],
        'sortOrder'  => (int)$row['sort_order'],
    ];
}
