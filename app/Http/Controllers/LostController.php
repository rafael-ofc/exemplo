<?php

namespace App\Http\Controllers;

use App\Models\Lost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LostController extends Controller
{
    public function read()
    {
        $lost = Lost::where('status', 'LOST')->orderBy('created_at', 'DESC')->get();
        foreach ($lost as $item) {
            $item['path'] = asset("storage/photos/$item->path");
            $item['created'] = date('Y-m-d', strtotime($item->created_at));
        }

        $recovered = Lost::where('status', 'RECOVERED')->orderBy('created_at', 'DESC')->get();
        foreach ($recovered as $item) {
            $item['path'] = asset("storage/photos/$item->path");
            $item['created'] = date('Y-m-d', strtotime($item->created_at));
        }

        return [
            'error' => '',
            'lost' => $lost,
            'recovered' => $recovered,
        ];
    }

    public function create(Request $request)
    {
        $data = Validator::make($request->all(), [
            'status' => 'string|uppercase',
            'body' => 'required|string',
            'where' => 'required|string',
            'photo' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        $data = $data->validated();

        $hash = md5(time() . rand(0, 100000) . time());
        $request->file('photo')->storeAs('public/photos', "$hash.png");
        $data['path'] = "$hash.png";
        unset($data['photo']);

        Lost::create($data);

        return [
            'error' => ''
        ];
    }

    public function update(Request $request, $id)
    {
        $lost = Lost::find($id);
        if (empty($lost)) return redirect()->route('login');

        $data = Validator::make($request->all(), [
            'status' => ['required', 'regex:/^(LOST|RECOVERED)$/i']
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        $data = $data->validated();
        $data['status'] = strtoupper($data['status']);

        $lost->update($data);

        return [
            'error' => '',
        ];
    }
}
