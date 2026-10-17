<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
   public function index(Request $request)
{
    $query = Vehicle::query();

    // Whitelist of allowed filter fields
    $allowedFilters = ['make', 'year'];

    foreach ($allowedFilters as $field) {
        if ($request->has($field)) {
            $query->where($field, $request->input($field));
        }
    }

    return response()->json($query->get());
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'price' => 'required|integer',
        ]);

        $vehicle = Vehicle::create($validated);

        return response()->json($vehicle, 201);
    }

    public function show(Vehicle $vehicle)
    {
        return response()->json($vehicle, 200);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'make' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer',
            'price' => 'sometimes|required|integer',
        ]);

        $vehicle->update($validated);

        return response()->json($vehicle, 200);
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->json(null, 204);
    }
}