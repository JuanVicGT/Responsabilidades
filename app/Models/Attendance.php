<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string update_at
 * @property string created_at

 * @property int extra_hours
 * @property string name
 * @property string date
 * @property string start_hour
 * @property string end_hour
 * @property string description

 * ---- Foreign keys
 * @property int id_user
 */
class Attendance extends Model
{
    use HasFactory;

    /* When you set `` to an empty array `[]`, it means
    that all attributes of the model are mass assignable */
    protected $guarded = [];
}
