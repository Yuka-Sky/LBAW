<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    public function updatePassword(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Find the user by email
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Nenhum usuário encontrado com este endereço de e-mail.']);
        }

        // Update the password in the database
        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Redirect back with success message
        return redirect()->route('login')->with('success', 'A palavra-passe foi alterada com sucesso!');
    }
}
