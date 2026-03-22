<?php
/**
 * API Router
 * Dispatches /api/* requests to the correct module handler.
 *
 * To add a new API route, add a new case below and create api/{module}/index.php
 */

$uri   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', trim($uri, '/'));
// parts[0] = 'api', parts[1] = module name

$module = $parts[1] ?? '';

$apiModules = [
    'projects' => __DIR__ . '/projects/index.php',
    // ─── Add new API routes here ────────────────────────
    // 'skills'   => __DIR__ . '/skills/index.php',
    // 'messages' => __DIR__ . '/messages/index.php',
];

if (isset($apiModules[$module])) {
    require $apiModules[$module];
} else {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(404);
    echo json_encode([
        'status'  => 'error',
        'message' => 'API endpoint not found',
        'available' => array_map(fn($k) => "/api/$k", array_keys($apiModules)),
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
