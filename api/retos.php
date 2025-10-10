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
        
        $sql = "SELECT * FROM retos WHERE activo = TRUE ORDER BY fecha_inicio DESC";
        
        $result = $conn->query($sql);
        $retos = [];
        
        while ($row = $result->fetch_assoc()) {
            $retos[] = $row;
        }
        
        echo json_encode($retos);
        $conn->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al cargar retos: ' . $e->getMessage()]);
    }
}
?>
