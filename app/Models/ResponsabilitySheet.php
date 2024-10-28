<?php

namespace App\Models;

use App\Http\Services\AppSettingService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string update_at
 * @property string created_at
 * @property string prefix_number

 * @property int number
 * @property float balance

 * ---- Foreign keys
 * @property int id_responsible
 * @property int created_by
 * @property int updated_by
 */
class ResponsabilitySheet extends Model
{
    use HasFactory;

    /* When you set `` to an empty array `[]`, it means
    that all attributes of the model are mass assignable */
    protected $guarded = [];

    public static function getNextNumber()
    {
        $appSettings = app(AppSettingService::class);
        $sequenceStart = $appSettings->get('sequence_start');

        /**
         * Luego de cargar la configuración, se limpia la configuración
         * para que luego se siga la secuencia de las hojas de responsabilidad creadas
         */
        if (is_numeric($sequenceStart)) {
            $appSettings->set('sequence_start', '');
            return (int) $sequenceStart;
        }

        $lastRecord = self::latest()->first();
        if ($lastRecord) {
            $lastNumber = $lastRecord->number;
            if (is_numeric($lastNumber)) {
                return ++$lastNumber;
            }
        }

        // Si no existe una configuración y tampoco hay un registro, se inicia el contador en 1
        return 1;
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'id_responsible', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lines()
    {
        return $this->hasMany(LineResponsabilitySheet::class, 'id_sheet', 'id');
    }

    public function recalculate()
    {
        $cashIn = 0.0;
        $cashOut = 0.0;
        $balance = 0.0;

        foreach ($this->lines as $key => $line) {
            $cashIn += $line->cash_in;
            $cashOut += $line->cash_out;

            if ($line->cash_in > 0.0) {
                $balance += $line->cash_in;
            }

            if ($line->cash_out > 0.0) {
                $balance -= $line->cash_out;
            }

            $line->update([
                'balance' => $balance,
            ]);
        }

        $this->balance = $balance;
        $this->cash_in = $cashIn;
        $this->cash_out = $cashOut;
        $this->save();
    }
}
