<?php

namespace App\Livewire\Backend\Event;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;

class EditEvent extends Component
{
    // Current event
    public $event;

    // Selected option
    public ?int $id_responsible = null;

    // Options list
    public $users;

    // Options list
    public $status_options;

    public function mount(?array $status_options, ?int $id)
    {
        $this->status_options = $status_options;
        $this->event = Event::find($id);
        $this->id_responsible = $this->event->id_responsible;
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
        return view('livewire.backend.event.edit-event');
    }
}
