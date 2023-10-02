<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function read()
    {
        return [
            'error' => '',
            'user' => Auth::user(),
        ];
    }

    public function update(Request $request)
    {
        $id = Auth::id();

        $validator = Validator::make($request->all(), [
            'name' => 'string|min:2',
            'email' => "email|unique:users,email,$id",
            'cpf' => "digits:11|unique:users,cpf,$id",
            'password' => 'string|confirmed',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        $user = User::find($id);
        $user->update($validator->validated());

        return [
            'error' => '',
            'user' => $user,
        ];
    }

    public function getReservation()
    {
        $authId = Auth::id();
        $user = User::find($authId);
        $units = $user->units->pluck('id');
        $reservations = Reservation::whereIn('unit_id', $units)->get();

        $list = [];
        foreach ($reservations as $reservation) {
            $area = $reservation->area;
            if (!$area->allowed) continue;

            $list[] = [
                'id' => $reservation->id,
                'date' => $reservation->date,
                'area' => [
                    'title' => $area->title,
                    'cover' => asset("storage/photos/$area->cover"),
                ],
            ];
        }

        return  [
            'error' => '',
            'list' => $list,
        ];
    }
}
