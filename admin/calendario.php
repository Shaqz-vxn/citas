<?php include "model/conexion.php"; ?>

<div id='calendar'></div>
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
    });
 </script>