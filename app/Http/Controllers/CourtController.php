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
        try {
            $courts = Court::all();
            if (!$courts) {
                return response()->json([
                    'message' => "No hay Canchas Actualmente"
                ], 200);
            }
            return response()->json([
                'data' => $courts
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
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
            return response()->json([
                'message' => "error en la validacion de datos",
                'error' => $validator->errors(),
            ], 400);
        }
        try {
            Court::create($request->all());

            return response()->json([
                "message" => "Cancha creada"
            ], 201);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $courts = Court::findOrFail($id);
            return response()->json([
                'data' => $courts
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            "name" => "sometimes|required|max:50|string",
            "surface_type" => "sometimes|required|string",
            "number_players" => "sometimes|required|integer",
            "price" => "sometimes|required",
            "description" => "sometimes|required|max:255",
            "is_active" => "sometimes|required"
        ]);
        try {
            $court = Court::findOrFail($id);
            $court->update($validatedData);

            return response()->json([
                'message' => 'Cancha Actualizada',
                'data' => $court
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $court = Court::findOrFail($id);

            $court->delete();

            return response()->json([
                'message' => 'Cancha eliminada',
                'data' => $court->name
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
