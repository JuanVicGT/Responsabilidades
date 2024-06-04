<x-layouts.app>
    @section('tab-title')
        {{ __('Collaborators') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Collaborators') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                    link="{{ route('user.create') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.user.user-table />
    </div>

</x-layouts.app>