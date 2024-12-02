<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con el modelo Reservation (un horario puede tener muchas reservas).
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
