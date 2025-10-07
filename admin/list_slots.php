<?php
include("model/conexion.php");

//eliminar
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM Disponibilidades WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id'=>$id]);
    header("Location: list_slots.php");
    exit;
}