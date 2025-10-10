<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'aquadata');

// Crear conexión
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        error_log("[v0] database.php - Error de conexión: " . $conn->connect_error);
        die("Error de conexión: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("[v0] database.php - Session iniciada: " . session_id());
}

// Función para verificar si el usuario está autenticado
function isAuthenticated() {
    $authenticated = isset($_SESSION['usuario_id']);
    error_log("[v0] database.php - isAuthenticated: " . ($authenticated ? 'true' : 'false'));
    error_log("[v0] database.php - Session actual: " . print_r($_SESSION, true));
    return $authenticated;
}

// Función para obtener el usuario actual
function getCurrentUser() {
    if (!isAuthenticated()) {
        error_log("[v0] database.php - getCurrentUser: No autenticado");
        return null;
    }
    
    $conn = getConnection();
    $usuario_id = $_SESSION['usuario_id'];
    
    error_log("[v0] database.php - getCurrentUser: Buscando usuario ID " . $usuario_id);
    
    $stmt = $conn->prepare("SELECT id, nombre, apellido, email, rol FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
    
    error_log("[v0] database.php - getCurrentUser: Usuario encontrado: " . print_r($usuario, true));
    
    $stmt->close();
    $conn->close();
    
    return $usuario;
}

// Función para requerir autenticación
function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: /login.php');
        exit();
    }
}
?>

