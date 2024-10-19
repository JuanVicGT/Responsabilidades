@php
    use App\Utils\Enums\StatusPasswordResetRequestEnum as Status;
@endphp

<section>
    <x-mary-card shadow class="py-0">
        <div class="flex py-4 justify-between">
            <div class="flex justify-start space-x-4">
                <x-mary-input icon="o-magnifying-glass" wire:model.live='search' placeholder="{{ __('search') }}..."
                    class="border-gray-500" clearable />
                <x-mary-select :options="$pagination_options" wire:model.live="pagination" class="h-2" />
            </div>
            <div class="flex justify-start space-x-4">
                <div>
                    {{ $rows->onEachSide(0)->links('components.layouts.custom-pagination') }}
                </div>
            </div>
        </div>

        {{-- You can use any `$wire.METHOD` on `@row-click` --}}
        <x-mary-table :headers="$headers" :rows="$rows" :sort-by="$sortBy" class="pb-4" with-pagination striped
            link="User/Edit/{user.id}">

            {{-- Overrides headers --}}
            @scope('header_id', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_user.username', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_status', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_description', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_created_at', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope
            @scope('header_updated_at', $header)
                <h2 class="text-xl font-bold inline">
                    {{ $header['label'] }}
                </h2>
            @endscope

            @scope('cell_status', $row)
                @if ($row->status === Status::NotVerified->value)
                    <x-mary-badge value="{{ __('Not Verified') }}" class="badge-warning" />
                @endif

                @if ($row->status === Status::Refused->value)
                    <x-mary-badge value="{{ __('Refused') }}" class="badge-error text-white dark:text-black" />
                @endif

                @if ($row->status === Status::Processed->value)
                    <x-mary-badge value="{{ __('Approved') }}" class="badge-success" />
                @endif
            @endscope

        </x-mary-table>

    </x-mary-card>
</section>
