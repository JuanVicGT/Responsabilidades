<x-layouts.app>
    @section('tab-title')
        {{ __('Add New') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Add New Event') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Return') }}" icon="o-arrow-uturn-left" class="btn-accent dark:btn-info"
                    link="{{ route('event.index') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endsection

    <livewire:backend.event.create-event :status_options="$status_options" />

</x-layouts.app>
