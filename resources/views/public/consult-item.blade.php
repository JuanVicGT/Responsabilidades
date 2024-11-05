<x-layouts.guest-custom>
    @section('tab-title')
        {{ __('Consult Item') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Consult Item') }}">
        </x-mary-header>
    @endsection

    {{-- Form --}}
    <x-mary-card shadow>
        Consulta de item
    </x-mary-card>

</x-layouts.guest-custom>
