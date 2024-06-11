<section class="w-full h-full">
    {{-- 
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script> 
    --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DB:', @json($events));

            let calendarEl = document.getElementById('calendar');
            let calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
                locales: ['es'],
                locale: 'es',
                height: window.innerHeight,
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: @json($events),
            });
            calendar.render();
        });
    </script>

    <div id="calendar"></div>

</section>
