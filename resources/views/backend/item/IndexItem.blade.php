<x-layouts.app>
    @section('tab-title')
        {{ __('Items') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Items') }}">
            @if (auth()->user()->is_admin || auth()->user()->can('create_item'))
                <x-slot:actions>
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('item.create') }}" no-wire-navigate />
                </x-slot:actions>
            @endif
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.item.item-table />
    </div>

</x-layouts.app>
