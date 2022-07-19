<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function GetAllPosts() {
        $cards = Post::all();
        return response()->json($cards);
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
}
