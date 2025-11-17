<?php
require_once("../model/conexion.php");

if (!isset($_GET['id'])) {
    die("ID no proporcionado.");
}

$id = intval($_GET['id']);

$sql = "SELECT estado FROM disponibilidades WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->execute([':id' => $id]);
$hora = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hora){
    die("La hora no existe.");
}

if ($hora['estado'] !== 'disponible'){
    header("Location: ../inicio.php?error=reservada");
    exit();
}

$sql = "DELETE FROM disponibilidades WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->execute([':id' => $id]);

header("Location: ../inicio.php?msg=eliminado");
exit();
?>
