<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;

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
    }

 
    // COMMANDS (WRITE ONLY)
 
    public function store(Request $request)
    {
        // Validation and command execution
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data['user_id'] = auth('api')->id();

        // Write operation 
        $postId = $this->postRepo->create($data)->id;
        return response()->json(['id' => $postId], 201);
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