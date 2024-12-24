<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostTagController extends Controller
{
    public function store( array $data){
        $validated = $data;

        DB::table('post_tag')->insert([
            'id_post' => $validated['id_post'],
            'id_tag'  => $validated['id_tag'],
        ]);

        return response()->json([
            'message' => 'Tag associada à notícia com sucesso.',
            'data' => $validated,
        ], 201);
    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id_post' => 'required|exists:post,id', 
            'id_tag'  => 'required|exists:tag,id',
        ]);

        $deleted = DB::table('post_tag')
            ->where('id_post', $validated['id_post'])
            ->where('id_tag', $validated['id_tag'])
            ->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Tag desassociada da notícia com sucesso.',
            ], 200);
        }

        return response()->json([
            'message' => 'Nenhuma associação para remover foi encontrada.',
        ], 404);
    }
}
