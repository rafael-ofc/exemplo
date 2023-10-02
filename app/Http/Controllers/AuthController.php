<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
            'cpf' => 'required|digits:11',
            'password' => 'required',
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        $data = $data->validated();

        if ($token = Auth::attempt($data)) {
            return [
                'error' => '',
                'token' => $token,
                'user' => Auth::user(),
            ];
        }

        return [
            'error' => 'Cpf ou senha inválida'
        ];
    }

    public function register(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|min:2|string',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|digits:11|unique:users,cpf',
            'password' => 'required|confirmed',
        ]);

        if ($data->fails()) {
            return ['error' => $data->errors()];
        }

        $data = $data->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $token = Auth::login($user);

        return [
            'error' => '',
            'token' => $token,
            'user' => $user
        ];
    }

    public function check()
    {
        $data = [
            'error' => '',
            'auth' => Auth::check(),
        ];

        if ($data['auth']) {
            $data['user'] = Auth::user();
        }

        return $data;
    }

    public function logout()
    {
        Auth::logout();

        return [
            'error' => '',
        ];
    }
}
