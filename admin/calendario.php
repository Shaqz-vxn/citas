<?php include "model/conexion.php"; ?>

<div id='calendar'></div>
 <script>
    document.addEventListener('DOMContentLoaded',function(){
        var calendar = new FullCalendar.Calendar(
            document.getElementById('calendar'),
            {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: 'get_slots.php',

                eventClick: function(info){

                    // permite eliminar SOLO horas disponibles
                    if (info.event.extendedProps.estado === 'disponible'){

                        if (confirm("¿Eliminar esta hora disponible?")) {
                            window.location.href = "delete/delete_disponibilidad.php?id=" + info.event.id;
                            return;
                        }
                    }
                }
            }
        );

        calendar.render();
    });
</script>