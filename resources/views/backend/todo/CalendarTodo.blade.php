<x-layouts.app>
    @section('tab-title')
        {{ __('Todos Calendar') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Todos Calendar') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('List View') }}" icon="o-clipboard-document-check" class="btn-primary"
                    link="{{ route('todo.index') }}" no-wire-navigate />
                @if (auth()->user()->is_admin || auth()->user()->can('create_todo'))
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('todo.create') }}" no-wire-navigate />
                @endif
            </x-slot:actions>
        </x-mary-header>
    @endsection

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
                events: @json($todos),
            });
            calendar.render();
        });
    </script>

    <div id="calendar"></div>

</x-layouts.app>
