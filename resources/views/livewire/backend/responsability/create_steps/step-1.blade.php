<x-mary-step step="1" text="{{ __('General Data') }}">
    <section class="grid grid-cols-4 gap-4">
        <div class="col-span-2">
            <x-mary-input label="{{ __('Number') }}" wire:model="form_number" autofocus required />
        </div>
        <div class="col-span-2">
            <x-mary-choices label="{{ __('Responsable') }}" debounce="500ms" wire:model="form_id_responsible" single
                icon="o-user" no-result-text="{{ __('No results found.') }}" required class="max-h-12 external-choice"
                :options="$option_users" searchable search-function="searchUsers">
                {{-- Item slot --}}
                @scope('item', $user)
                    <x-mary-list-item :item="$user" sub-value="work_position">
                        <x-slot:avatar>
                            @if ($user->avatar)
                                <x-mary-avatar image="{{ asset('storage/' . $user->avatar) }}"
                                    class="bg-orange-100 w-8 h8 rounded-full" />
                            @else
                                <x-mary-icon name="o-user" class="bg-orange-100 p-2 w-8 h8 rounded-full" />
                            @endif
                        </x-slot:avatar>
                    </x-mary-list-item>
                @endscope
            </x-mary-choices>
        </div>
    </section>
</x-mary-step>
