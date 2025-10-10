<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $conn = getConnection();
        
        $sql = "SELECT e.*, u.nombre, u.apellido 
                FROM encuestas e 
                JOIN usuarios u ON e.creador_id = u.id 
                WHERE e.activa = TRUE
                ORDER BY e.fecha_creacion DESC";
        
        $result = $conn->query($sql);
        $encuestas = [];
        
        while ($row = $result->fetch_assoc()) {
            $encuestas[] = $row;
        }
        
        echo json_encode($encuestas);
        $conn->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al cargar encuestas: ' . $e->getMessage()]);
    }
}
?>

