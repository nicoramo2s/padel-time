<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courts = Court::all();
        return JsonResponse(data: $courts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|max:100|string|min:3|unique:courts",
            "surface_type" => "required|string",
            "number_players" => "required|integer",
            "price" => "required",
            "description" => "required|max:255",
            "is_active" => "required"
        ]);
        if ($validator->fails()) {
            return JsonResponse(errors: $validator->errors(), status: 400);
        }
        $court = Court::create($request->all());

        return JsonResponse(message: "Cancha creada con exito", data: $court, status: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $courts = Court::findOrFail($id);
        return JsonResponse(data: $courts, status: 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "sometimes|required|max:50|string",
            "surface_type" => "sometimes|required|string",
            "number_players" => "sometimes|required|integer",
            "price" => "sometimes|required",
            "description" => "sometimes|required|max:255",
            "is_active" => "sometimes|required"
        ]);
        $court = Court::findOrFail($id);
        $court->update($request->all());

        return JsonResponse(message: 'Actualizado con exito', data: $court, status: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $court = Court::findOrFail($id);

        $court->delete();

        return JsonResponse(message: 'Eliminado con exito', data: $court, status: 200);
    }
}
