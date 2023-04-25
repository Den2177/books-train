<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        User::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, User $user)
    {
        $data = $request->collect()->filter(fn($i) => $i !== null)->toArray();
        $user->update($data);

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back();
    }
}
