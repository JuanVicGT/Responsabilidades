<section class="w-full h-full">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

    <x-mary-card shadow>
        <div id="calendar"></div>
    </x-mary-card>
</section>
