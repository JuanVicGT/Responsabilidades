<x-layouts.app>
    @section('tab-title')
        {{ __('Todos List') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Todos List') }}">
            <x-slot:actions>
                <x-mary-button label="{{ __('Calendar View') }}" icon="o-calendar-days"
                    class="btn-primary text-white dark:text-black" link="{{ route('todo.calendar') }}" no-wire-navigate />
                @if (auth()->user()->is_admin || auth()->user()->can('create_todo'))
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('todo.create') }}" />
                @endif
            </x-slot:actions>
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.todo.todo-table />
    </div>

</x-layouts.app>
