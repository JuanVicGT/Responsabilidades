<?php

namespace App\Livewire\Backend\Event;

use App\Models\User;
use Livewire\Component;

class CreateEvent extends Component
{
    public $name;
    public $start_date;
    public $end_date;
    public $status;
    public $description;
    public $start_hour;
    public $end_hour;

    // Selected option
    public ?int $id_responsible = null;

    // Options list
    public $users;

    // Options list
    public $status_options;

    public function mount($status_options)
    {
        $this->status_options = $status_options;

        $this->id_responsible = old('id_responsible');
        $this->name = old('name');
        $this->start_date = old('start_date');
        $this->end_date = old('end_date');
        $this->status = old('status');
        $this->description = old('description');
        $this->start_hour = old('start_hour');
        $this->end_hour = old('end_hour');

        $this->search();
    }

    // Also called as you type
    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->id_responsible)->get();

        $this->users = User::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption); // <-- Adds selected option
    }

    public function render()
    {
        return view('livewire.backend.event.create-event');
    }
}
