<x-layouts.app>
    @section('tab-title')
        {{ __('Todos') }}
    @endsection

    @section('content-header')
        <x-mary-header title="{{ __('Todos') }}">
            @if (auth()->user()->is_admin || auth()->user()->can('create_todo'))
                <x-slot:actions>
                    <x-mary-button label="{{ __('Add New') }}" icon="o-plus" class="btn-success"
                        link="{{ route('todo.create') }}" />
                </x-slot:actions>
            @endif
        </x-mary-header>
    @endsection

    <div>
        <livewire:backend.todo.todo-table />
    </div>

</x-layouts.app>
