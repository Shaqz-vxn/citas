<!DOCTYPE html>
<html>
<head>
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php
require_once 'model/conexion.php';

// OBTENER ÁREAS
$areas = $db->query("SELECT id, nombre FROM areas ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Registrar Usuario</div>

                <div class="card-body">
                    <form method="POST" action="metodos/registrar_usuario.php">

                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>

                        <!-- Username -->
                        <div class="form-group">
                            <label for="username">Usuario:</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <!-- Selección de área -->
                        <div class="form-group">
                            <label for="area_id">Área:</label>
                            <select name="area_id" id="area_id" class="form-control" required>
                                <option value="">Seleccione un área...</option>
                                <?php foreach($areas as $area): ?>
                                    <option value="<?= $area['id'] ?>">
                                        <?= htmlspecialchars($area['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Carga dinámica de cargos según el área -->
                        <div class="form-group">
                            <label for="cargo_id">Cargo:</label>
                            <select name="cargo_id" id="cargo_id" class="form-control" required>
                                <option value="">Seleccione un área primero...</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Registrar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT: Cargar cargos según el área seleccionada -->
<script>
document.getElementById('area_id').addEventListener('change', function(){

    const areaId = this.value;

    // Limpia los cargos mientras carga
    const cargoSelect = document.getElementById('cargo_id');
    cargoSelect.innerHTML = '<option value="">Cargando cargos...</option>';

    // AJAX para obtener los cargos del área
    fetch('get_cargos_por_area.php?area_id=' + areaId)
        .then(response => response.json())
        .then(data => {
            cargoSelect.innerHTML = '<option value="">Seleccione un cargo...</option>';

            data.forEach(c => {
                cargoSelect.innerHTML += `
                    <option value="${c.id}">${c.nombre}</option>
                `;
            });
        });
});
</script>

</body>
</html>
