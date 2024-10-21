<x-layouts.app>
    @section('tab-title')
        {{ __('Responsability Sheets') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Responsability Sheets') }}">
            @if (auth()->user()->is_admin || auth()->user()->can('create_responsability'))
                <x-slot:actions>
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('responsability-sheet.create') }}" no-wire-navigate />
                </x-slot:actions>
            @endif
        </x-mary-header>
    @endsection

</x-layouts.app>
