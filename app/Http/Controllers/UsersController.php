<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:15',
        ]);

        try {
            $users = Users::create([ 
                'username' => $request->username, 
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'Users  berhasil dibuat.',
                'user' => [
                    'id' => $users->id,
                    'username' => $users->username,
                    'name' => $users->name,
                    'email' => $users->email,
                    'phone' => $users->phone,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembuatan user gagal'], 500);
        }
    }

    public function index() 
    {
        $users = Users::all();
        return response()->json($users, 200);
    }

    public function show($id)
    {
        $user = Users::findOrFail($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $id,
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'phone' => 'nullable|string|max:15',
        ]);

        try {
            $users = Users::findOrFail($id);

            if ($request->has('username')) {
                $users->username = $request->username;
            }

            if ($request->has('name')) {
                $users->name = $request->name;
            }

            if ($request->has('email')) {
                $users->email = $request->email;
            }

            if ($request->has('phone')) {
                $users->phone = $request->phone;
            }

            if ($request->has('password')) {
                $users->password = Hash::make($request->password);
            }

            $users->save();

            return response()->json([
                'message' => 'User  berhasil diperbarui.',
                'users' => [
                    'id' => $users->id,
                    'username' => $users->username,
                    'name' => $users->name,
                    'email' => $users->email,
                    'phone' => $users->phone,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User  update gagal'], 500);
        }
    }

    public function destroy($id)
    {
        $users = Users::find($id);
        
        if (!$users) {
            return response()->json(['message' => 'Users  tidak ditemukan'], 404);
        }
        
        $users->delete();
    
        return response()->json(['message' => 'Users  berhasil dihapus'], 200);
    }
}