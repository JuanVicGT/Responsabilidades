<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_item
 *
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class DamagedItems extends Model
{
    use HasFactory;
}
