<?php
include '../admin/model/conexion.php';

$sql = "SELECT id, fecha, hora, estado FROM Disponibilidades";
$result = $conexion->query($sql);
$conexion->query("DELETE FROM Disponibilidades WHERE fecha < CURDATE()");

$events = [];
while ($row = $result->fetch_assoc()){
    $color = ($row['estado'] == 'disponible') ? '#28a745' : '#dc3545';
    $events[] = [
        'id' => $row['id'],
        'title' => ucfirst($row['estado']),
        'start' => $row['fecha'].'T'.$row['hora'],
        'color' => $color,
        'extendedProps' => [
            'estado' => $row['estado']
        ]
    ];
}

echo json_encode($events);