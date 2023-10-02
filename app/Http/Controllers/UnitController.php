<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\Pet;
use App\Models\Unit;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function read($id)
    {
        $unit = Unit::find($id);
        if (empty($unit)) return redirect()->route('login');

        foreach ($unit->peoples as $people) {
            $people['birthdate'] = date('d/m/Y', strtotime($people->birthdate));
        }

        return [
            'error' => '',
            'peoples' => $unit->peoples,
            'vehicles' =>  $unit->vehicles,
            'pets' => $unit->pets,
        ];
    }

    public function setPeople(Request $request)
    {
        $data = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|min:2',
            'birthdate' => 'required|date',
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        People::create($data->validated());

        return [
            'error' => '',
        ];
    }

    public function setVehicle(Request $request)
    {
        $data = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'title' => 'required|string',
            'color' => 'required|string',
            'plate' => 'required|string',
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        Vehicle::create($data->validated());

        return [
            'error' => '',
        ];
    }

    public function setPet(Request $request)
    {
        $data = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string',
            'race' => 'required|string',
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        Pet::create($data->validated());

        return [
            'error' => '',
        ];
    }

    public function deletePeople($id)
    {
        $people = People::find($id);
        if (empty($people)) return redirect()->route('login');

        $people->delete();

        return [
            'error' => '',
        ];
    }

    public function deleteVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        if (empty($vehicle)) return redirect()->route('login');

        $vehicle->delete();

        return [
            'error' => '',
        ];
    }

    public function deletePet($id)
    {
        $pet = Pet::find($id);
        if (empty($pet)) return redirect()->route('login');

        $pet->delete();

        return [
            'error' => '',
        ];
    }
}
