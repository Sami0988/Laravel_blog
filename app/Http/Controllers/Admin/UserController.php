<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    
public function report()
{
    $totalUsers = User::count();
    $adminCount = User::where('role', 'Admin')->count();
    $userCount = User::where('role', 'user')->count();
    $postCount = Post::count(); 

    return response()->json([
        'totalUsers' => $totalUsers,
        'adminCount' => $adminCount,
        'userCount' => $userCount,
        'totalPosts' => $postCount,
    ]);
}
}
