<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanController extends Controller
{
    public function create($id)
    {
        $this->authorize('create', Ban::class);
        $user = User::findOrFail($id);
        return view('pages.bans', compact('user'));
    }

    public function remove($banId)
    {
        $ban = Ban::findOrFail($banId);
        $this->authorize('remove', Ban::class);
        $ban->delete();

        return response()->json(['message' => 'Ban apagado com sucesso.'], 200);
    }

    public function store(Request $request, $id)
    {
        $this->authorize('create', Ban::class);
        $request->validate([
            'reason' => 'required|string|max:200',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:begin_date',
        ]);

        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            return redirect()->back()->withErrors(['error' => 'Tu não te podes banir.']);
        }

        $ispermanent = $request->has('permanent') && $request->permanent == '1' ? true : false;
        $endDate = $ispermanent ? $request->begin_date : $request->end_date;

        Ban::create([
            'id_user' => $user->id,
            'id_admin' => Auth::id(),
            'reason' => $request->reason,
            'permanent_bool' => $ispermanent,
            'begin_date' => $request->begin_date,
            'end_date' => $endDate,
        ]);

        return redirect()->route('technical_page', ['id' => Auth::user()->id])->with('success', 'Utilizador banido com sucesso.');
    }

    public static function checkBan($userId)
    {
        $ban = Ban::where('id_user', $userId)
            ->where(function ($query) {
                $query->where('permanent_bool', true)
                      ->orWhere('end_date', '>=', now());
            })
            ->first();

        return $ban;
    }
}
