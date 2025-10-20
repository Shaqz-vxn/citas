<?php include "model/conexion.php"; ?>

<div id='calendar'></div>

<!-- Modal de reserva -->
 <div class="modal fade" id="modalReserva" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Reservar hora</h5></div>
            <div class="modal-body">
                <form id="formReserva">
                    <input type="hidden" name="slot_id" id="slot_id">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Correo</label>
                        <input type="email" name="correo" class="form.control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mensaje opcional (opcional)</label>
                        <textarea name="mensaje" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirmar reserva</button>
                </form>
            </div>
        </div>
    </div>
 </div>

 <script>
    document.addEventListener('DOMContentLoaded',function(){
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'),{
            initialView: 'dayGridMonth',
            locale: 'es',
            events: 'get_slots.php',
            eventClick: function(info){
                if(info.event.extendedProps.estado ==='disponible'){
                    document.getElementById('slot_id').value = info.event.id;
                    var modal = new bootstrap.Modal(document.getElementById('modalReserva'));
                    modal.show();
                }
            }
        });
        calendar.render();

        document.getElementById('formReserva').addEventListener('submit', function(e){
            e.preventDefault;
            fetch('book_slot.php',{
                method: 'POST',
                body: new FormData(this)
            }).then(res => res.json()).then(data =>{
                if(data.ok){
                    alert('Reserva realizada con exito');
                    bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
                    calendar.refetchEvents();
                } else {
                    alert('Error: '+data.msg);
                }
            });
        });
    });
 </script>