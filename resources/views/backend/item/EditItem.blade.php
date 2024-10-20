<x-layouts.app>

    @section('custom-js')
        <script src="{{ asset('assets/js/utils.js') }}"></script>
        <script src="{{ asset('assets/js/create_item.js') }}"></script>
    @endsection

    @section('tab-title')
        {{ __('Edit Item') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Edit Item') }}" subtitle="{{ $item->name }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Return') }}" icon="o-arrow-uturn-left" class="btn-accent dark:btn-info"
                    link="{{ route('item.index') }}" />
                @if (auth()->user()->is_admin || auth()->user()->can('create_item'))
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('item.create') }}" />
                @endif
            </x-slot:actions>
        </x-mary-header>
    @endsection

    <x-mary-card shadow>
        {{-- Form --}}
        <x-mary-form method="POST" action="{{ route('item.update') }}" x-data="{ submitButtonDisabled: false }"
            x-on:submit="submitButtonDisabled = true">
            @csrf
            @method('patch')

            <input type="hidden" name="id" value="{{ $item->id }}">

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <x-mary-input label="{{ __('Code ID') }}" type="text" name='code' required autofocus
                        value="{{ old('code', $item?->code) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('code')" />
                </div>
                <div>
                    <x-input-label for="unit_value" :value="__('Unit Value') . '*'" />
                    <input name='unit_value' required value="{{ old('unit_value', $item?->unit_value) }}"
                        class="input input-primary w-full peer mt-2" x-mask:dynamic="$money($input)" />
                    <x-input-error class="mt-2" :messages="$errors->get('unit_value')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Quantity') }}" type="number" step="1" name='quantity' required
                        value="{{ old('quantity', $item?->quantity) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                </div>
                <div>
                    <x-mary-input label="{{ __('Total') }}" name='amount' x-mask:dynamic="$money($input)"
                        value="{{ old('amount', $item?->amount) }}" readonly icon="o-currency-dollar" />
                    <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                </div>
                <div>
                    <x-mary-textarea label="{{ __('Description') }}" type="text" name='description'
                        rows="5">{{ old('description', $item?->description) }}</x-mary-textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
                <div>
                    <x-mary-textarea label="{{ __('Observations') }}" type="text" name='observations'
                        rows="5">{{ old('observations', $item?->observations) }}</x-mary-textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('observations')" />
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="w-full mt-4 flex justify-end">
                <x-mary-button type="submit" class="btn-success" x-bind:disabled="submitButtonDisabled">
                    <x-mary-loading class="text-primary" x-show="submitButtonDisabled" />
                    <div x-show="!submitButtonDisabled">
                        <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M48 96V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V170.5c0-4.2-1.7-8.3-4.7-11.3l33.9-33.9c12 12 18.7 28.3 18.7 45.3V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H309.5c17 0 33.3 6.7 45.3 18.7l74.5 74.5-33.9 33.9L320.8 84.7c-.3-.3-.5-.5-.8-.8V184c0 13.3-10.7 24-24 24H104c-13.3 0-24-10.7-24-24V80H64c-8.8 0-16 7.2-16 16zm80-16v80H272V80H128zm32 240a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z" />
                        </svg> {{ __('Save') }}
                    </div>
                </x-mary-button>
            </div>

        </x-mary-form>
    </x-mary-card>

</x-layouts.app>
