<x-layouts.app>
    @section('tab-title')
        {{ __('Settings') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Settings') }}" />
    @endsection

    {{-- Form --}}
    <x-mary-card shadow>
        <x-mary-form method="POST" action="{{ route('app_setting.store') }}" x-data="{ submitButtonDisabled: false }"
            x-on:submit="submitButtonDisabled = true">
            @csrf

            @if (!empty($settings))

                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach ($settings as $setting)
                        @if ($setting['type'] == 'text')
                            <x-mary-input label="{{ __($setting['title']) }}" type="{{ $setting['type'] }}"
                                name="{{ $setting['key'] }}" value="{{ $config->get($setting['key']) }}"
                                hint="{{ $setting['description'] ?? '' }}" />
                        @endif

                        @if ($setting['type'] == 'number')
                            <x-mary-input label="{{ __($setting['title']) }}" type="{{ $setting['type'] }}"
                                name="{{ $setting['key'] }}" value="{{ $config->get($setting['key']) }}"
                                hint="{{ $setting['description'] ?? '' }}" />
                        @endif

                        @if ($setting['type'] == 'checkbox')
                            <x-mary-checkbox label="{{ __($setting['title']) }}" name="{{ $setting['key'] }}"
                                hint="{{ $setting['description'] ?? '' }}" :checked="$config->get($setting['key'])" />
                        @endif
                    @endforeach
                </div>

            @endif

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
