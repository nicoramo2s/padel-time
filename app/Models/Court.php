<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surface_type',
        'number_players',
        'price',
        'description',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con el modelo Reservation (una cancha tiene muchas reservas).
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
