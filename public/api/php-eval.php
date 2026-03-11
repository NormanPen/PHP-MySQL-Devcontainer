<?php

declare(strict_types=1);

// Diese Datei soll NUR im Sandbox-Container Code ausführen.
if (getenv('SANDBOX_MODE') !== '1') {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Sandbox mode not enabled']);
    exit;
}

header('Content-Type: application/json');

$code = $_POST['code'] ?? '';

if ($code === '') {
    echo json_encode([
        'output' => '',
        'error'  => 'No code provided',
    ]);
    exit;
}

// Führende/trailing PHP-Tags optional entfernen
$normalized = preg_replace('/^\s*<\?php\b/i', '', $code);
$normalized = preg_replace('/\?>\s*$/', '', $normalized);

$executionOutput = null;
$executionError  = null;

ob_start();
try {
    eval($normalized);
    $executionOutput = ob_get_clean();
} catch (Throwable $e) {
    ob_end_clean();
    $executionError = $e->getMessage();
}

echo json_encode([
    'output' => $executionOutput,
    'error'  => $executionError,
]);
