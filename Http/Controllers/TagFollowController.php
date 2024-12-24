<?php

namespace App\Http\Controllers;

use App\Models\TagFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TagFollowController extends Controller
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
        $idUserFollower = auth()->id();
        $idTag = $request->input('id_tag');
        $exists = TagFollow::where('id_user', $idUserFollower)
                        ->where('id_tag', $idTag)
                        ->exists();

        if ($exists) {
            return back()->with('message', 'Já segue esta tag.');
        }

        TagFollow::insert([
            'id_user' => $idUserFollower,
            'id_tag' => $idTag,
        ]);

        return back()->with('message', 'Começou a seguir este utilizador!');
    }

    public function destroy($tagId)
    {
        DB::table('tag_follows')
        ->where('id_user', auth()->id())
        ->where('id_tag', $tagId)
        ->delete();

        return back()->with('message', 'Deixou de seguir esta tag.');
    }

    public function show(TagFollow $tagFollow)
    {
        //
    }

    public function edit(TagFollow $tagFollow)
    {
        //
    }

    public function update(Request $request, TagFollow $tagFollow)
    {
        //
    }
}
