<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Utils\Enums\AlertType;
use App\Utils\Enums\StatusPasswordResetRequest;
use Illuminate\Http\Request;

class PasswordResetRequestController extends Controller
{
    const MODULE_NAME = 'prequest';

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.prequest.CreatePrequest');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('storePrequest', [
            'username' => 'required|exists:users,username',
        ]);

        $user = User::firstWhere('username', $validated['username']);

        $passwordResetRequest = $user->pendingPasswordResetRequest;
        if (isset($passwordResetRequest->status) && $passwordResetRequest->status === StatusPasswordResetRequest::NotVerified->value) {
            $this->addAlert(AlertType::Warning, __('There is already a pending password change request for this user. Please wait for it to be verified.'));
            return back()->with('alerts', $this->getAlerts());
        }

        PasswordResetRequest::create([
            'user_id' => $user->id,
            'description' => $request->description,
            'status' => StatusPasswordResetRequest::NotVerified
        ]);

        $user->need_password_reset = true;
        $user->save();

        $this->addAlert(AlertType::Success, __('A password change request has been created. Please wait for it to be verified.'));
        return redirect()->route('prequest.create')->with('alerts', $this->getAlerts());
    }
}
