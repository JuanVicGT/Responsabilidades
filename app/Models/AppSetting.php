<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string settings
 * @property string update_at
 * @property string created_at
 */
class AppSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'settings'
    ];

    /** 
     * Esta función no está pensada para cargar la configuración establecida.
     * 
     * En su lugar está pensada para crear el formulario, validación y la carga de la configuración.
     * 
     * Por el momento solo se tendrá compatibilidad con los elementos input.
     */
    public static function  getFullSettings()
    {
        return [
            // Texts
            ['key' => 'mayor', 'type' => 'text', 'title' => __('conf-mayor')],
            ['key' => 'director_afim', 'type' => 'text', 'title' => __('conf-afmin')],
            ['key' => 'sequence_prefix', 'type' => 'text', 'title' => __('conf-sequence-prefix'), 'description' => __('conf-sequence-prefix-description')],
            // Numbers
            ['key' => 'sequence_start', 'type' => 'number', 'title' => __('conf-sequence-start'), 'description' => __('conf-sequence-start-description')],
            ['key' => 'pagination', 'type' => 'number', 'title' => __('conf-pagination')],
        ];
    }
}
