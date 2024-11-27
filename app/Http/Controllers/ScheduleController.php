<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $schedule = Schedule::all();
            return response()->json($schedule, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'datetime' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $schedule = Schedule::create($request->all());
            return response()->json("El Horario Creado es $schedule->datetime", 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            return response()->json($schedule);
        } catch (\Throwable $th) {
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
            "datetime" => "date"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            // Buscar la reserva por ID
            $schedule = Schedule::findOrFail($id);

            // Actualizar los campos
            $schedule->update($request->all());

            return response()->json([
                'message' => 'Horario actualizado con exito',
                'data' => $schedule
            ], 200);
        } catch (\Throwable $th) {
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
            $schedule = Schedule::findOrFail($id);

            // Eliminar el horario
            $schedule->delete();

            return response()->json([
                'message' => 'Horario eliminado con exito'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
