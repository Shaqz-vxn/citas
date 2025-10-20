<?php
include("model/conexion.php");

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_hora'])){
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';

    if ($fecha && $hora){
        try {
            $sql = "INSERT INTO Disponibilidades (fecha, hora) VALUES (:fecha, :hora)";
            $stmt = $db->prepare($sql);
            $stmt->execute([':fecha' => $fecha, ':hora' => $hora]);

            header("Location: inicio.php?msg=ok");
            exit;
        }catch (PDOException $e){
            $error = "Error al agregar la hora: " . $e->getMessage();
        }
    } else {
        $error = "Debe completar fecha y hora.";
    }
}

if (isset($_GET['msg']) && $_GET['msg'] == 'ok'){
    $success = "Hora agregada correctamente.";
}

include("header.php");
include("navbar.php");
?>
    <div class="container mt-5">
    <p class="text-left"><kbd>Esta es tu plataforma administrativa.</kbd></p>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>
</div>

<div class="container"><br><br>
    <div class="row"><div class="col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Agregar hora disponible</h5>
                    <p class="card-text">Añade una nueva fecha y hora para reservas.</p>
                    
                    <form method="post" action="inicio.php">
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora:</label>
                            <input type="time" class="form-control" name="hora" id="hora" required>
                        </div>
                        <button type="submit" name="agregar_hora" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Agregar
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Consultar Citas</h5>
                    <p class="card-text">Accede al módulo para consultar las citas generadas.</p>
                    <a href="mod_reservas.php" class="btn btn-primary"><i class="fas fa-calendar"></i> Ir al módulo</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Medios de contacto</h5>
                    <p class="card-text">Añade o edita los medios de contacto.</p>
                    <?php include "contacto/form_contacto.php"; ?>
                </div>
            </div>
        </div>

    </div></div><div class="container mt-4"> <div class="card">
        <div class="card-header text-center">
            <p class="text-secondary mb-0"><b>Tus citas y horas disponibles</b></p> </div>
        <div class="card-body">
            <?php include "calendario.php"; ?>
        </div>
    </div>
</div>

<?php
include("../footer.php");
?>