<?php

namespace App\Livewire\Profile;

use App\Utils\FileTools;
use App\Utils\Alerts;
use App\Models\User;
use App\Utils\Enums\AlertType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfileInformationForm extends Component
{
    use Alerts;
    use WithFileUploads;

    public $user;

    public $avatar;
    public $avatar_path;
    public $name;
    public $last_name;
    public $phone;
    public $email;
    public $birthdate;
    public $address;

    public function render()
    {
        return view('livewire.profile.update-profile-information-form');
    }

    public function mount(User $user)
    {
        $this->user = $user;

        $this->avatar_path = $user->avatar;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->birthdate = $user->birthdate;
        $this->address = $user->address;
    }

    public function rules()
    {
        return [
            // required
            'name' => ['required', 'string', 'max:255'],

            // optional
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user->id)],
            'avatar' => ['nullable', File::image()->min('1kb')->max('5mb')->dimensions(Rule::dimensions()->maxWidth(500)->maxHeight(500))],
            'address' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
        ];
    }

    public function save()
    {
        $this->validate();

        $avatar_path = $this->user->avatar;
        if ($this->avatar)
            $avatar_path = $this->avatar->storeAs('avatars', $this->user->id . '.webp');

        $this->user->update([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'address' => $this->address,
            'avatar' => $avatar_path,
        ]);

        FileTools::clearTempFiles();

        $this->addAlert(AlertType::Success, 'Your profile has been updated!');

        return redirect(route('profile.edit'))->with('alerts', $this->getAlerts());
    }
}
