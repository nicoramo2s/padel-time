<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_id',
        'schedule_id',
        'status',
    ];

    /**
     * Relación con el modelo Court (una reserva pertenece a una cancha).
     */
    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    /**
     * Relación con el modelo Timestamp (una reserva pertenece a un horario).
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
