<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string update_at
 * @property string created_at

 * @property string code
 * @property int quantity
 * @property bool is_available
 * @property string description
 * @property string observations
 * @property float unit_value
 * @property float amount
 */
class Item extends Model
{
    use HasFactory;

    /* When you set `` to an empty array `[]`, it means
    that all attributes of the model are mass assignable */
    protected $guarded = [];
}
