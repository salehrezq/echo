<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentController extends Controller
{
    public function index(Post $post) {
        return response()->json($post->comments()->with('user')->latest()->get());
    }
    
    public function store(Post $post) {
         $comment = $post->comments()->create([
             'body' => request('body'),
             'user_id' => auth()->id(),
         ]);
         
         $comment = Comment::where('id', $comment->id)->with('user')->first();
         
//         event(new \App\Events\NewComment($comment));
        broadcast(new \App\Events\NewComment($comment))->toOthers();
         
         return $comment->toJson();
    }
}
