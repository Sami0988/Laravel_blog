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

    public function index()
    {
        return response()->json($this->postRepo->getAll());
    }

    public function show($id)
    {
        return response()->json($this->postRepo->getById($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $data['user_id'] = auth('api')->id();

        $post = $this->postRepo->create($data);
        return response()->json($post, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
        ]);

        $updated = $this->postRepo->update($id, $data);
        return response()->json($updated);
    }

    public function destroy($id)
    {
        $this->postRepo->delete($id);
        return response()->json(['message' => 'Post deleted']);
    }
}