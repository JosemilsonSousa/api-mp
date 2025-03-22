<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(['users' => User::all()]);
    }

    public function store(Request $request)
    {
        $user = new User;

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->doc      = $request->doc;
        $user->password = Hash::make($request->email);

        $user->save();

        return response()->json(['user' => $user]);
    }

    public function show(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        dd($request->all());
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'doc'   => $request->doc,
        ]);
        return response()->json(['user' => $user]);
    }

    public function destroy(User $user)
    {
        //
    }
}
