<x-layouts.app>

    @section('tab-title')
        {{ __('Edit Responsability Sheet') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Number') }}: {{ $sheet->number }}" subtitle="{{ __('Edit Responsability Sheet') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Return') }}" icon="o-arrow-uturn-left" class="btn-accent dark:btn-info"
                    link="{{ route('responsability-sheet.index') }}" />
                @if (auth()->user()->is_admin || auth()->user()->can('create_responsability'))
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('responsability-sheet.create') }}" />
                @endif
            </x-slot:actions>
        </x-mary-header>
    @endsection

</x-layouts.app>
