<?php
include 'admin/model/conexion.php';

//$conexion->query("DELETE FROM Disponibilidades WHERE fecha < CURDATE()");
$sql = "SELECT id, fecha, hora, estado FROM Disponibilidades WHERE estado='disponible'";
$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$events = [];
foreach ($rows as $r) {
    $horaFormateada = substr($r['hora'], 0, 5);
    $events[] = [
        'id' => $r['id'],
        'title' => 'Disponible',
        'start' => $r['fecha'].'T'.$r['hora'],
        'end' => $r['fecha'].'T'.$r['hora'],
        'color' => '#ffffff',
        'textColor' => '#000000ff',
        'backgroundColor' => '#3bc550ff',
        'borderColor' => '#ffffff',
        'display' => 'block',
        'extendedProps' => [
            'estado' => $r['estado'],
            'hora' => $horaFormateada
        ]
    ];
}

echo json_encode($events);