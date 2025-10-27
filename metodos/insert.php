<?php
// Verificar si se envió el formulario correctamente
if (!isset($_POST['oculto'])) {
    exit("Acceso no autorizado.");
}

// Incluir conexión a la base de datos
include '../admin/model/conexion.php';

// Obtener datos del formulario
$nombre    = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo    = $_POST['correo'];
$servicio  = $_POST['servicio'];
$fecha     = $_POST['fecha'];
$hora      = $_POST['hora'];
$mensaje   = $_POST['mensaje'];
$estado    = $_POST['estado'];

// Verificar si ya existe una reserva en esa fecha y hora
try {
    $consulta = $db->prepare("SELECT COUNT(*) FROM Reservas WHERE Fecha = ? AND Hora = ?");
    $consulta->execute([$fecha, $hora]);
    $existeCita = $consulta->fetchColumn();

    if ($existeCita > 0) {
        header('Location: ../error.php');
        exit();
    }

    // Insertar nueva reserva
    $sentencia = $db->prepare("INSERT INTO Reservas (Nombre, Apellidos, Correo, Servicio, Fecha, Hora, MensajeAdicional, Estado)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insertado = $sentencia->execute([$nombre, $apellidos, $correo, $servicio, $fecha, $hora, $mensaje, $estado]);

    // Si la inserción fue exitosa, actualizar la disponibilidad
    if ($insertado) {
        $update = $db->prepare("UPDATE Disponibilidades SET estado = 'ocupado' WHERE fecha = ? AND hora = ?");
        $update->execute([$fecha, $hora]);

        header('Location: ../exito.php');
        exit();
    } else {
        echo "Error al registrar la reserva.";
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>
