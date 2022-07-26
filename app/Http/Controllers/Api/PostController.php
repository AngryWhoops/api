<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function GetAllPosts()
    {
        $posts = Post::with('user')->get();
        return response()->json($posts);
    }

    public function CreateMyPost(Request $request)
    {
        $newPost = new Post(
            array(
                'body' => $request->get('body'),
            )
        );
        $newPost->save();
    }

    //Все посты пользователя по логину
    public function GetPostsByUser($login)
    {
        $user = User::where('login', $login)->first();
        $postsWithAuthor = Post::with('user')->where('user_id', '=', $user->id)->get();
        return response()->json($postsWithAuthor);
    }

    public function GetPostsByHashtag($hashtag)
    {
        //TODO
        $newHashTag = Hashtag::where('name', $hashtag);
        $posts = $newHashTag->posts()->get();
        return response()->json($posts);
    }
}
