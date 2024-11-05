<x-layouts.guest-custom>
    @section('tab-title')
        {{ __('Consult Sheet') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Consult Sheet') }}">
        </x-mary-header>
    @endsection

    <livewire:public.consult.consult-sheet :sheet="$sheet" />

</x-layouts.guest-custom>
