<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function updateRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|in:Admin,Renter,User',
        ]);

        $user = User::findOrFail($id);
        $user->role = $validated['role'];
        $user->save();

        return response()->json(['message' => 'Role updated successfully!']);
    }
}