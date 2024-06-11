<x-layouts.app>
    @section('tab-title')
        {{ __('Dashboard') }}
    @endsection

    @include('backend.event.CalendarEvent')

</x-layouts.app>
