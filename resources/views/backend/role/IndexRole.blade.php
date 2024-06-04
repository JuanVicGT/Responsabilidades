<x-layouts.app>
    @section('tab-title')
        {{ __('Roles') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Roles') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                    link="{{ route('role.create') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.role.role-table />
    </div>

</x-layouts.app>
