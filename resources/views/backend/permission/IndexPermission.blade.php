<x-layouts.app>
    @section('tab-title')
        {{ __('Permissions') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Permissions') }}">
            @if (auth()->user()->is_admin || auth()->user()->can('create_permission'))
                <x-slot:actions>
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('permission.create') }}" />
                </x-slot:actions>
            @endif
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.permission.permission-table />
    </div>

</x-layouts.app>
