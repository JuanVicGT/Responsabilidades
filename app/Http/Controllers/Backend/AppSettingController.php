<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Utils\Enums\AlertTypeEnum;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    /**
     * Este controlador mostrará directamente un formulario
     * de configuración
     */
    public function index()
    {
        $config = $this->config;
        $settings = AppSetting::getFullSettings();
        return view('backend.setting.IndexSetting', compact('settings', 'config'));
    }

    /**
     * Este controlador tendrá únicamente una solicitud POST
     */
    public function store(Request $request)
    {
        $settings = AppSetting::getFullSettings();
        $newSettings = [];

        foreach ($settings as $setting) {
            if (empty($request->get($setting['key']))) {
                continue;
            }

            $newSettings[$setting['key']] = $request->get($setting['key']);
        }

        $this->config->setFromArray($newSettings);
        $this->addAlert(AlertTypeEnum::Success, __('Updated successfully'));
        return redirect()->route('app_setting.index')->with('alerts', $this->getAlerts());
    }
}
