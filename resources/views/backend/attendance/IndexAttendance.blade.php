<x-layouts.app>
    @section('tab-title')
        {{ __('Attendances') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Attendances') }}" />
    @endsection

    @if (auth()->user()->is_admin || auth()->user()->can('create_attendance'))
        <livewire:backend.attendance.attendance-create />
    @endif

    <div>
        <livewire:backend.attendance.attendance-table />
    </div>

</x-layouts.app>
