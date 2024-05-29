<x-layouts.app>
    @section('tab-title')
        {{ __('Add New') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Add New Collaborator') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Return') }}" icon="o-arrow-uturn-left" class="btn-info"
                    link="{{ route('user.index') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endsection

</x-layouts.app>
