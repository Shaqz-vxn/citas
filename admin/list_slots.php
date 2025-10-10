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

//Listar
$sql = "SELECT * FROM Disponibilidades ORDER BY fecha, hora";
$stmt = $db->prepare($sql);
$stmt->execute();
$slots = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Horas disponibles</title></head>
<body>
    <h2>Horas registradas</h2>
    <p><a href="add_slot.php">Agregar nueva hora</a></p>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Acciones</th></tr>
        <?php foreach($slots as $s): ?>
        <tr>
            <td><?= $s['id'] ?></td>
            <td><?= $s['fecha'] ?></td>
            <td><?= substr($s['hora'],0.5) ?></td>
            <td><?= $s['estado'] ?></td>
            <td>
                <a href="list_slots.php?delete=<?= $s['id'] ?>" onclick="return confirm('Eliminar?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>