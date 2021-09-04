<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * コメントの投稿
     *
     * @param  \Illuminate\Http\Requests\CommentRequest  $request
     * @return 
     */
    public function store(CommentRequest $request, Comment $comment)
    {
        $data = $request->all();
        $comment->fill($data);
        $comment->user_id = $request->user()->id;
        $comment->portfolio_id = $data['portfolio_id'];
        $comment->save();

        return back();
    }
}
