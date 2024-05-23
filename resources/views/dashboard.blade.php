<x-layouts.app>
    @section('nav-title')
        {{ __('Default Name') }}
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __('Developed with love, by a student learning a new technology') }} ♥!
                {{ asset('assets/images/no_image.jpg') }}
            </div>
        </div>
    </div>

</x-layouts.app>
