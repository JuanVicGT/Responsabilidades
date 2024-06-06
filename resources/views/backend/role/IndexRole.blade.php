<x-layouts.app>
    @section('tab-title')
        {{ __('Roles') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Roles') }}">
            @if (auth()->user()->is_admin || auth()->user()->can('create_role'))
                <x-slot:actions>
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('role.create') }}" />
                </x-slot:actions>
            @endif
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.role.role-table />
    </div>

</x-layouts.app>
