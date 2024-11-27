<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Reservation::all();
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
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
            return response()->json($validator->errors(), 400);
        }
        try {
            $reservation = Reservation::create($request->all());

            return response()->json([
                "message" => "Reservacion realizada con Exito",
                "data" => $reservation
            ], 200);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->load(['court', 'schedule']);
            return response()->json([
                "data" => $reservation
            ], 200);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
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
            return response()->json($validator->errors(), 400);
        }

        try {
            // Buscar la reserva por ID
            $reservation = Reservation::findOrFail($id);

            // Actualizar los campos de la reserva
            $reservation->update($request->all());

            return response()->json([
                'message' => 'Reservacion actualizada con exito',
                'data' => $reservation
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Buscar la reserva por ID
            $reservation = Reservation::findOrFail($id);

            // Eliminar la reserva
            $reservation->delete();

            return response()->json([
                'message' => 'Reservacion eliminada con exito'
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
