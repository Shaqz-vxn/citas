<?php 
#prueba de envio de datos
print_r ($_GET);
if (!isset($_GET["id"])) {
    header  ("Location: http://localhost/citas/admin/error.php");
}

$EliminarRegistro = $_GET['id'];
#conexion a db
include '../model/conexion.php';
#Sentencia sql para eliminar registros
$sentencia = $db->prepare('DELETE  FROM reservas WHERE id=?;');
$resultado = $sentencia->execute([$EliminarRegistro]);
// Obtener ID de la reserva a eliminar
$id = $_GET['id']; // o $_POST['id'] dependiendo del método

// Eliminar la reserva
$conexion->query("DELETE FROM Reservas WHERE ID = $id");

// Eliminar también la disponibilidad asociada (por si no se usa la FK)
$conexion->query("DELETE FROM Disponibilidades WHERE reserva_id = $id");

if ($resultado==true) {
    header ('Location: http://localhost/citas/admin/mod_reservas.php');
}else{
    echo 'Error al eliminar el registro';
}
?>