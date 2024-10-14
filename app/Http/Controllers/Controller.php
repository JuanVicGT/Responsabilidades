<?php

namespace App\Http\Controllers;

use App\Http\Services\AppSettingService;
use App\Models\AppSetting;
use App\Utils\Alerts;

// Use to authorize views (without model)
use App\Policies\GeneralPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

abstract class Controller
{
    use Alerts;

    protected $config;

    public function __construct()
    {
        $settings = AppSetting::getFullSettings();
        $this->config = app(AppSettingService::class, compact('settings'));
    }

    /**
     * Checks if the current user is allowed to realize a specific action on a
     * given view based on the GeneralPolicy.
     * 
     * @param string module_action Represents the action being performed in the module, 
     * such as "index", "show", "create", "edit" and "delete".
     * @param string module_name Name of the module that is being accessed or viewed.
     */
    protected function general_auth(string $module_action, string $module_name)
    {
        Gate::allowIf(GeneralPolicy::$module_action(Auth::user(), $module_name));
    }
}
