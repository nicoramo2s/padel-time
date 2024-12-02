<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ReservationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api', 'role:user'])->only('store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();

        return JsonResponse(data: $reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'court_id' => 'required|exists:courts,id',
            'schedule_id' => 'required|exists:schedules,id',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return JsonResponse(errors: $validator->errors(), status: 400);
        }

        $reservation = Reservation::create([
            'court_id' => $request->court_id,
            'schedule_id' => $request->schedule_id,
            'status' => $request->status,
            'user_id' => auth()->user()->id, // Asignar el usuario autenticado
        ]);

        return JsonResponse(message: "Reservacion realizada con Exito", data: $reservation, status: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->load(['court', 'schedule']);
        return JsonResponse(data: $reservation, status: 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'court_id' => 'nullable|exists:courts,id', // ID de la cancha
            'schedule_id' => 'nullable|exists:schedules,id', // ID del horario
            'status' => 'nullable|string|in:pending,confirmed,canceled', // Estado válido
        ]);

        if ($validator->fails()) {
            return JsonResponse(errors: $validator->errors(), status: 400);
        }

        // Buscar la reserva por ID
        $reservation = Reservation::findOrFail($id);

        // Actualizar los campos de la reserva
        $reservation->update($request->all());

        return JsonResponse(message: 'Actualizado con exito', data: $reservation, status: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la reserva por ID
        $reservation = Reservation::findOrFail($id);

        // Eliminar la reserva
        $reservation->delete();

        return JsonResponse(message: 'Eliminado con exito', data: $reservation, status: 200);
    }
}
