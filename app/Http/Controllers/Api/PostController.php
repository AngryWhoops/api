<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function GetAllPosts()
    {
        $posts = Post::all();
        return response()->json($posts);
    }


    public function CreateMyPost(Request $request)
    {
        $newPost = new Post(
            array(
                'body' => $request->get('body')
            )
        );
        $newPost->save();
    }


    public function GetPostsByUser($login)
    {
        /* $user = User::where('login', $login)->first();
        $allposts = $user->posts()->get();
         */
        $ps = User::where('login', $login)->posts()->get()->with('user_id')->get();
        return response()->json($ps);
    }

    public function GetPostsByHashtag($hashtag)
    {
        $newHashTag = Hashtag::where('name', $hashtag);
        $posts = $newHashTag->posts()->get();
        return response()->json($posts);
    }
}
