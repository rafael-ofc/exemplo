<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WarningController extends Controller
{
    public function read()
    {
        $user = User::find(Auth::id());
        $units = $user->units->pluck('id');
        $warnings = Warning::whereIn('unit_id', $units)->get();

        foreach ($warnings as $warning) {
            $photos = json_decode($warning->photos);

            $array = [];
            foreach ($photos as $photo) {
                $array[] = asset("storage/photos/$photo");
            }

            $warning['photos'] = $array;
            $warning['created'] = date('Y-m-d', strtotime($warning->created_at));
        }

        return [
            'error' => '',
            'list' => $warnings,
        ];
    }

    public function create(Request $request)
    {
        $data = Validator::make($request->all(), [
            'unit_id' => 'required',
            'title' => 'required|string',
            'status' => 'string',
            'photos.*' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        $data = $data->validated();

        $unit = Unit::find($data['unit_id']);
        if (empty($unit) || $unit->user_id != Auth::id()) {
            return redirect()->route('login');
        }

        if (isset($data['photos'])) {
            $photos = $request->file('photos');

            $array = [];
            foreach ($photos as $photo) {
                $hash = md5(time() . rand(0, 100000) . time());
                $photo->storeAs('public/photos', "$hash.png");
                $array[] = "$hash.png";
            }

            $data['photos'] = json_encode($array);
        } else {
            $data['photos'] = json_encode([]);
        }

        Warning::create($data);

        return [
            'error' => ''
        ];
    }
}
