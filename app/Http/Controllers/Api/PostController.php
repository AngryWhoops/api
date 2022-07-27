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
        $posts = Post::with('user', 'hashtags')->get();
        return response()->json($posts);
    }

    public function CreateMyPost(Request $request)
    {
        /* $text = $request->get('body'); */
        $text = [$request->get('body')];
        $tagsArray = [];
        foreach ($text as $element) {
            if ($element[0] == '@') {
                array_push($tagsArray, $element);
            }
        };
        /* $newPost = new Post(
            array(
                'body' => $request->get('body'),

            )
        );
        $newPost->save(); */
        return response()->json($tagsArray);
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
        $newHashTag = Hashtag::where('name', $hashtag)->first();
        $posts = Hashtag::find($newHashTag->id)->posts()->with('user', 'hashtags')->get();

        return response()->json($posts);
    }
}
