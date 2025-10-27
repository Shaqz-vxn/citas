<form action="metodos/insert.php" method="POST" id="formReserva">
  <input type="hidden" name="oculto" value="1">
  <input type="hidden" name="fecha" id="fecha">
  <input type="hidden" name="hora" id="hora">

  <div class="form-group">
    <label>Nombre</label>
    <input type="text" name="nombre" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Apellidos</label>
    <input type="text" name="apellidos" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Correo electrónico</label>
    <input type="email" name="correo" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Servicio</label>
    <input type="text" name="servicio" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Mensaje adicional</label>
    <textarea name="mensaje" class="form-control"></textarea>
  </div>

  <input type="hidden" name="estado" value="pendiente">

  <div class="text-center">
    <button type="submit" class="btn btn-success">Enviar reserva</button>
  </div>
</form>
