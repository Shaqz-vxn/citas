<?php
include("model/conexion.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';

    if($fecha && $hora){
        try{
            $sql = "INSERT INTO Disponibilidades (fecha, hora) VALUES (:fecha, hora)";
            $stmt = $db ->prepare($sql);
            $stmt->execute([':fecha'=>$fecha, ':hora'=>$hora]);
            header("Location: list_slots.php?msg=ok");
            exit;
        } catch(PDOException $e){
            $error = $e->getMessage();
        }
    }else{
        $error = "Debe completar fecha y hora.";
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Agregar hora disponible</title></head>
<body>
    <h2>Agregar hora disponible</h2>
    <?php if(!empty($error)): ?><p style="color:red;"><?=htmlspecialchars($error)?></p><?php endif; ?>
    <form method="post">
        <label>Fecha: <input type="date" name="fecha" required></lable><br>
        <label>Hora: <input type="time" name="hora" required></lable><br>
        <button type="submit">Agregar</button>
    </form>
    <p><a href="list_slots.php">Ver horas</a></p>
</body>
</html>
