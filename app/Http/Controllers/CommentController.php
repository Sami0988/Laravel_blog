<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Add comment to a post
    public function store(Request $request, $postId)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($postId);

        $comment = $post->comments()->create([
            'content' => $data['content'],
            'user_id' => auth('api')->id(),  
        ]);

        return response()->json($comment, 201);
    }

    // Get a post with its comments
    public function show($postId)
    {
        $post = Post::with('comments.user')->findOrFail($postId);
        return response()->json($post);
    }
}
