<?php
require_once 'model/conexion.php';

if (!isset($_GET['area_id'])) {
    echo json_encode([]);
    exit;
}

$areaId = intval($_GET['area_id']);

// Consulta: obtener cargos del área seleccionada
$sql = "SELECT id, nombre FROM cargos WHERE area_id = :area ORDER BY nombre ASC";
$stmt = $db->prepare($sql);
$stmt->execute([':area' => $areaId]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
