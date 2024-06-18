<section>
    <x-mary-form action="{{ route('attendance.store') }}">
        @csrf
        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <x-mary-input label="{{ __('Date') }}" type="date" name='date' required autofocus />
            </div>
            <div>
                <x-mary-input label="{{ __('Date') }}" type="date" name='date' required autofocus />
            </div>
            <div>
                <x-mary-input label="{{ __('Date') }}" type="date" name='date' required autofocus />
            </div>
        </div>

        <div class="flex justify-end">
            <x-mary-button label="{{ __('Add Attendance') }}" class="btn-success" type="submit" spinner="save" />
        </div>

    </x-mary-form>
</section>
