<?php

namespace App\Http\Controllers;

use App\Models\Billet;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BilletController extends Controller
{
    public function read()
    {
        $user = User::find(Auth::id());
        $units = $user->units->pluck('id');
        $billets = Billet::whereIn('unit_id', $units)->get();

        foreach ($billets as $billet) {
            $billet['path'] = asset("storage/docs/$billet->path");
        }

        return [
            'error' => '',
            'list' => $billets,
        ];
    }
}
