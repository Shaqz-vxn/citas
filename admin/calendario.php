<?php
// Incluir archivo de configuración de la base de datos
include("model/conexion.php");

try {
    // Consulta SQL para obtener las citas de la tabla "Reservas"
$sql = "SELECT ID AS id, Nombre AS title, CONCAT(Fecha, 'T', Hora) AS start FROM Reservas";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Crea un array para almacenar las citas
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo "Error en la base de datos: " . $e->getMessage();
}

// Cierra la conexión a la base de datos
$db = null;

// Convierte las citas a formato JSON para que JavaScript las pueda utilizar
$citas_json = json_encode($citas);
?>


    <div id='calendar'></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolBar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth, timeGridWeek,timeGridDay' },
            dayHeaderFormat: {weekday: 'short', day: 'numeric' },
            showNonCurrentDAtes: false,
            fixedWeekCount: false,
            events: [
                //Disponibles en verde
                {
                    url: 'public/list_slots.php',
                    color: 'green',
                    textColor: 'white'
                },
                //Reservados en rojo
                {
                    url: 'admin/list_reservas_json.php',
                    color: 'red',
                    textColor: 'white'
                }
            ],
            eventClick: function(info){
                var id = info.event.id;
                if(id && id.startsWith('slot-')){
                    var slot_id = info.event.extendedProps.slot_id;
                }
            }
            
            navLinks: true, // Habilitar enlaces en los eventos para navegar
            editable: false // Permitir arrastrar y soltar eventos para moverlos
        });
        calendar.render();
    });
</script>
