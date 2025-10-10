<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/database.php';

error_log("[v0] check-auth.php - Session ID: " . session_id());
error_log("[v0] check-auth.php - Session data: " . print_r($_SESSION, true));

if (isAuthenticated()) {
    $usuario = getCurrentUser();
    error_log("[v0] check-auth.php - Usuario autenticado: " . print_r($usuario, true));
    echo json_encode([
        'authenticated' => true,
        'usuario' => $usuario
    ]);
} else {
    error_log("[v0] check-auth.php - Usuario NO autenticado");
    echo json_encode(['authenticated' => false]);
}
?>

