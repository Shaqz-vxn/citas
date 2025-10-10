<?php
header('Content-Type: application/json; charset=utf-8');
include("../admin/model/conexion.php");

$sql = "SELECT id, fecha, hora, estado * FROM Disponibilidades WHERE estado = 'disponible' ORDER BY fecha,hora";
$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchALL(PDO:: FETCH_ASSOC);

//convertir a formato para fullcalendar (start: 'YYYY-MM-DD')
$events = [];
foreach($rows as $r){
    $events[] = [
        'id' => 'slot-'.$r['id'],
        'title' => 'Disponible: '.substr($r['hora'],0.5),
        'start' => $r['fecha'].'T'.substr($r['hora'],0.5).':00',
        'extendedProps' => ['slot_id'=>$r['id']]
    ];
}
echo json_encode($events);