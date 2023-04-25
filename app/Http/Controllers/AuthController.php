<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\SymbolRule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        $v = validator($data, [
            'login' => 'required|alpha:ascii',
            'password' => ['required', 'string', 'min:6', 'regex:/[a-zA-Z]+/', 'confirmed', function($attribute, $value, $fail) {
                if (!preg_match("/[^\w\d\s]/", $value)) {
                    $fail(':attribute должен содеражить хотябы один спец символ');
                }
            }],
        ]);

        if ($v->fails()) {
            return $this->vError($v);
        }

        unset($data['password_confirmation']);
        User::create($data);

        return response()->json(
            [
                'message' => 'success',
            ]
        );
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $v = validator($data, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($v->fails()) {
            return $this->vError($v);
        }

        $user = User::where('login', $data['login'])->firstWhere('password', $data['password']);

        if (!$user) {
            return $this->error('User not found');
        }

        $token = Str::random();

        $user->update(['token' => $token]);

        return [
            'token' => $token,
            'isAdmin' => $user->isAdmin ? 'true' : '',
        ];
    }
}
