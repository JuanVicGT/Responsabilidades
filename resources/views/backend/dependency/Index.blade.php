<x-layouts.app>
    @section('tab-title')
        {{ __('Dependencies') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Dependencies') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                    link="{{ route('dependency.create') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endsection

</x-layouts.app>
