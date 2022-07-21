<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function GetAllPosts() {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function GetPostById($id) {
        $post = Post::find($id);
        return response()->json($post);
    }

    public function CreatePost(Request $request) {
        $newPost = new Post(
            array(
                'body' => $request->get('body')
            )
        );
        $newPost->save();
    }

    public function DeleteAll() {
        Post::truncate();
    }

    public function DeletePostById($id) {
        $deletePost = Post::find($id);
        $deletePost->delete();
    }

    public function GetPostsByUser(Request $request) {
        $posts = User::where('login', '=', $request);
        return response()->json($posts);
    }
}
