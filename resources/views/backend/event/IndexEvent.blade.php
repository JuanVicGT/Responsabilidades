<x-layouts.app>
    @section('tab-title')
        {{ __('Events') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Events') }}">
            @if (auth()->user()->is_admin || auth()->user()->can('create_event'))
                <x-slot:actions>
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('event.create') }}" />
                </x-slot:actions>
            @endif
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.event.event-table />
    </div>

</x-layouts.app>
