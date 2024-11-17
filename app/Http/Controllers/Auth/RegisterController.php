<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class RegisterController extends Controller
{
    public function updateRole(Request $request, $id)
{
    $validated = $request->validate([
        'role' => 'required|in:Admin,Renter,User', // Validate the role
    ]);

    $user = User::findOrFail($id);
    $user->role = $validated['role'];
    $user->save();

    return response()->json(['message' => 'Role updated successfully!']);
}
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:Admin,Renter,User', // Validate the role
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'], // Assign role
        ]);

        return response()->json(['message' => 'User registered successfully!']);
    }
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    // Validate the registration data
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}