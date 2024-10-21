<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int order
 * @property bool is_active
 * @property string update_at
 * @property string created_at
 * @property string observations

 * @property float balance
 * @property float subtotal
 * @property float cash_in
 * @property float cash_out

 * ---- Foreign keys
 * @property int id_responsability_sheet
 * @property int id_item
 */
class LineResponsabilitySheet extends Model
{
    use HasFactory;

    /* When you set `` to an empty array `[]`, it means
    that all attributes of the model are mass assignable */
    protected $guarded = [];
}
