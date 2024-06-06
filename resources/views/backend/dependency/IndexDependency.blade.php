<x-layouts.app>
    @section('tab-title')
        {{ __('Dependencies') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Dependencies') }}">
            @if (auth()->user()->is_admin || auth()->user()->can('create_dependency'))
                <x-slot:actions>
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('dependency.create') }}" />
                </x-slot:actions>
            @endif
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.dependency.dependency-table />
    </div>

</x-layouts.app>
