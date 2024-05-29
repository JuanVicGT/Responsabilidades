<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string update_at
 * @property string created_at

 * @property string name
 * @property string start_date
 * @property string end_date
 * @property string status
 * @property string start_hour
 * @property string end_hour
 * @property string description

 * ---- Foreign keys
 * @property int id_responsible
 */
class Event extends Model
{
    use HasFactory;

    /* When you set `` to an empty array `[]`, it means
    that all attributes of the model are mass assignable */
    protected $guarded = [];
}
