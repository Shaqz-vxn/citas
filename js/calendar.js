document.addEventListener('DOMContentLoaded', function(){
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        timeZone: 'local',

        events: 'metodos/get_disponibilidades.php',
        dateClick: function(info){
            document.getElementById('fecha').value = info.dateStr;
            $('#modalReserva').modal('show');
        },

        eventClick: function(info){
            if (info.event.extendedProps.estado === 'disponible'){
                document.getElementById('fecha').value = info.event.startStr.split('T')[0];
                document.getElementById('hora').value = info.event.startStr.split('T')[1].subString(0,5);
                $('#modalReserva').modal('show');
            }
        }
    });

    calendar.render();

    const form = document.querySelector('#formReserva');
    if (form){
        form.addEventListener('submit', function(e){
            setTimeout(() => calendar.refretchEvents(), 1500);
        });
    }
});