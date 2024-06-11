<x-layouts.app>
    @section('tab-title')
        {{ __('Edit Event') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Edit Event') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Return') }}" icon="o-arrow-uturn-left" class="btn-accent dark:btn-info"
                    link="{{ route('event.index') }}" />
                @if (auth()->user()->is_admin || auth()->user()->can('create_event'))
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('event.create') }}" />
                @endif
            </x-slot:actions>
        </x-mary-header>
    @endsection

    @livewire('backend.event.edit-event', ['status_options' => $status_options, 'id' => $id])

</x-layouts.app>
