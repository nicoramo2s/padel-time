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
        $schedule = Schedule::all();
        return JsonResponse($schedule, 200);
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
            return JsonResponse(errors: $validator->errors(), status: 400);
        }

        $schedule = Schedule::create($request->all());
        return JsonResponse(data: $schedule->datetime, message: "El Horario Creado exitosamente", status: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        return JsonResponse(data: $schedule, message: 'actualizado con exito', status: 200);
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
        // Buscar la reserva por ID
        $schedule = Schedule::findOrFail($id);

        // Actualizar los campos
        $schedule->update($request->all());

        return JsonResponse(data: $schedule, message: 'Horario actualizado con exito', status: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // Buscar la reserva por ID
        $schedule = Schedule::findOrFail($id);

        // Eliminar el horario
        $schedule->delete();

        return JsonResponse(status: 200, message: 'Horario eliminado con exito');
    }
}
