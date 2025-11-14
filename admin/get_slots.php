<?php
include "model/conexion.php";

header('Content-Type: application/json');

$eventos = [];//para guardar los eventos

try{
    $sql = "SELECT * FROM Disponibilidades";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($slots as $s){
        $color = '';
        $titulo = '';

        if ($s['estado'] == 'disponible'){
            $color = '#28a745';
            $titulo = 'Disponible: ' . substr($s['hora'], 0, 5);
        } else if ($s['estado'] == 'reservado') {
            $color = '#dc3545';
            $titulo = 'Reservado: ' . substr($s['hora'], 0 ,5);
        } else {
            //$color = '#6c757d';
            //$titulo = 'Ocupado: ' . substr($s['hora'], 0, 5);
        }

        $eventos[] = [
            'id' => $s['id'],
            'title' => $titulo,
            'start' => $s['fecha'] .'T'.$s['hora'],
            'color' => $color,
            'extendedProps' => [
                'estado' => $s['estado']
            ]
        ];
    }
}catch (PDOException $e) {
    echo json_encode([]);
    exit;
}

echo json_encode($eventos);