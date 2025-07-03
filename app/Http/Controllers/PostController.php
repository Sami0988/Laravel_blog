<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->postRepo = $postRepo;
    }

    // QUERIES (READ ONLY)
    public function index()
    {
        // Optimized read: Select only needed fields
        return response()->json(
            $this->postRepo->getAll(['id', 'title', 'created_at'])
        );
    }

    public function show($id)
    {
        // Read-specific logic (e.g., no sensitive fields)
        return response()->json(
            $this->postRepo->getById($id, ['id', 'title', 'content', 'created_at'])
        );
    }public function myPosts()
{
    $userId = auth('api')->id();

    $posts = \App\Models\Post::with([
        'comments' => function ($query) {
            $query->select('id', 'post_id', 'user_id', 'content', 'created_at');
        },
        'comments.user:id,name,email' 
    ])
    ->where('user_id', $userId)
    ->get(); 

    return response()->json($posts);
}



    // COMMANDS (WRITE ONLY)
 
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $user = auth()->user();

    $post = Post::create([
        'title' => $request->title,
        'description' => $request->description,
        'user_id' => $user->id,
        'author_name' => $user->name,
    ]);

    return response()->json($post, 201);
}


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        // Write operation 
        $this->postRepo->update($id, $data);
        return response()->json(['message' => 'Post updated']);
    }

    public function destroy($id)
    {
        // Write operation
        $this->postRepo->delete($id);
        return response()->json(['message' => 'Post deleted']);
    }
}