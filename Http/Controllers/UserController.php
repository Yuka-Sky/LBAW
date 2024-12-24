<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        if (!auth()->check()){ abort(403);}
        $user = User::find($id);
        if (!$user) { abort(404);}

        $isFollowing = Follow::where('id_user_follower', auth()->id())
                         ->where('id_user_followed', $user->id)
                         ->exists();
    
        return view('pages.profile', ['user' => $user, 'isFollowing' => $isFollowing]);
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    // User deletes their account
    public function anonymize(Request $request, $id)
    {
        if (!auth()->check()){ abort(403);}
        $user = User::findOrFail($id);

        $this->authorize('anonymize', $user);

        $user->name = 'Anonymous';
        $user->email = 'anonymized_' . $user->id . '@example.com';
        $user->password = bcrypt('00000000');
        $user->remember_token = null;
        $user->reputation = 0;
        $user->save();
    
        auth()->logout();

        return redirect('/posts')->with('message', 'Sua conta foi anonimizada com sucesso.');
    }
    // Delete user's account by admin
    public function anonByAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (!auth()->user()->is_admin) {
            abort(403, 'Não estas autorizado a executar esta ação.');
        }
    
        $user->name = 'Anonymous';
        $user->email = 'anonymized_' . $user->id . '@example.com';
        $user->password = bcrypt('00000000'); 
        $user->remember_token = null;
        $user->reputation = 0; 
        $user->save();
    
        return response()->json(['message' => 'Conta apagada com sucesso.']);
    }
    // Promote and unpromote user
    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Não pode alterar o seu próprio estatuto de administrador.'
            ], 403);
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return response()->json([
            'success' => true,
            'is_admin' => $user->is_admin,
            'message' => $user->is_admin ? 'Utilizador promovido a admin.' : 'Utilizador despromovido.'
        ]);
    }
}
