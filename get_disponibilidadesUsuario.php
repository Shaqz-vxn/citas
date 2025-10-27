<?php
include 'admin/model/conexion.php';

$sql = "SELECT id, fecha, hora, estado FROM Disponibilidades WHERE estado='disponible'";
$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$events = [];
foreach ($rows as $r) {
    $horaFormateada = substr($r['hora'], 0, 5);
    $events[] = [
        'id' => $r['id'],
        'title' => 'Disponible ✓',
        'start' => $r['fecha'].'T'.$r['hora'],
        'end' => $r['fecha'].'T'.$r['hora'],
        'color' => '#28a745',
        'textColor' => '#ffffff',
        'backgroundColor' => '#28a745',
        'borderColor' => '#28a745',
        'display' => 'block',
        'extendedProps' => [
            'estado' => $r['estado'],
            'hora' => $horaFormateada
        ]
    ];
}

echo json_encode($events);