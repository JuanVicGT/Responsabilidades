<?php

namespace App\Livewire\Backend\Event;

use App\Models\User;
use Livewire\Component;

class CreateEvent extends Component
{
    // Selected option
    public ?int $id_responsible = null;

    // Options list
    public $users;
    
    // Options list
    public $status_options;

    public function mount($status_options)
    {
        $this->status_options = $status_options;
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
