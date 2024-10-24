<x-layouts.app>
    @section('tab-title')
        {{ __('Add New') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Add New Responsability Sheet') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Responsability Sheets') }}" icon="c-clipboard-document-check"
                    class="btn-accent dark:btn-info" link="{{ route('responsability-sheet.index') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endsection

    <livewire:backend.responsability.responsability-sheet-create />

</x-layouts.app>
