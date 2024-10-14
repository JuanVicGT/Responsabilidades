<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    const MODULE_NAME = 'app_setting';

    /**
     * Esta ventana no tiene un listado como tal,
     * directamente se muestra el formulario de configuración
     */
    public function index()
    {
        $this->general_auth('index', self::MODULE_NAME);
        return view('backend.setting.IndexSetting');
    }

    /**
     * Dado que las configuraciones se guardan en un JSON
     * la configuración se actualiza o crea directamente
     */
    public function store(Request $request)
    {
        //
    }
}
