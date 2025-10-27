document.addEventListener('DOMContentLoaded', function(){
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        timeZone: 'local',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        events: 'get_disponibilidadesUsuario.php',
        displayEventTime: true,

        eventClick: function(info){
            if (info.event.extendedProps.estado === 'disponible'){
                const fechaHora = info.event.startStr.split('T');
                const fecha = fechaHora[0];
                const hora = info.event.extendedProps.hora;
                
                document.getElementById('fecha').value = fecha;
                document.getElementById('hora').value = hora;
                
                // Formatear la fecha para mostrar
                const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                // Actualizar el título del modal
                const modalTitle = document.querySelector('.modal-title');
                if (modalTitle) {
                    modalTitle.innerHTML = `Reservar cita para el ${fechaFormateada}<br>Hora: ${hora}`;
                }
                
                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('modalReserva'));
                modal.show();
            }
        }
    });

    calendar.render();

    const form = document.querySelector('#formReserva');
    if (form){
        form.addEventListener('submit', function(e){
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;
            
            if(!fecha || !hora) {
                e.preventDefault();
                alert('Por favor, seleccione una fecha y hora válida');
                return;
            }
            
            setTimeout(() => calendar.refetchEvents(), 1500);
        });
    }
});