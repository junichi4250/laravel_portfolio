<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * タグ別記事一覧表示
     * 
     * @param  string $name
     * @return View
     */
    public function show(string $name)
    {
        $tag = Tag::where('name', $name)->first();

        return view('tags.show', [
            'tag' => $tag,
        ]);
    }
}
