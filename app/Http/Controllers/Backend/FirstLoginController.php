<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Utils\Enums\AlertIcon;
use App\Utils\Enums\AlertType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class FirstLoginController extends Controller
{
    /**
     * Ommit First Login, this Controller is accessible for the first login
     * of the user.
     */
    protected function first_login(Request $request)
    {
        return;
    }

    /**
     * Display the first login view.
     */
    public function show_first_login(Request $request)
    {
        return view('backend.user.FirstLogin', [
            'user' => $request->user(),
            'alert_message' => __('Is your first login, you will need to change your password'),
            'alert_type' => AlertType::Warning,
            'alert_icon' => AlertIcon::Warning
        ]);
    }

    public function update_password(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
            'is_first_login' => false
        ]);

        $this->addAlert(AlertType::Success, __('Your password has been updated!'));
        return redirect()->route('dashboard')->with('alerts', $this->getAlerts());
    }
}
