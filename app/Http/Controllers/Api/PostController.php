<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\PostUser;
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
        $text = $request->get('body');
        $arrText = explode(' ', $text);
        $tagsArray = [];
        $marksArray = [];
        foreach ($arrText as $element) {
            if ($element[0] == '#') {
                array_push($tagsArray, $element);
            } elseif ($element[0] == '@') {
                array_push($marksArray, $element);
            }
        };
        $newPost = new Post(
            array(
                'body' => $request->get('body'),
                'user_id' => 1,
            )
        );
        $newPost->save();
        $newPostUser = new PostUser(
            array(
                'post_id' => $newPost->id,
                'user_id' => 1
            )
        );
        $newPostUser->save();
    }

    //Все посты пользователя по логину и отметке
    public function GetPostsByUser($login)
    {
        /* $user = User::where('login', $login)->first();
        $postsWithAuthor = Post::with('user', 'markedUsers')->where('user_id', '=', $user->id)->get(); */

        $user = User::where('login', $login)->first();
        $postsWithAuthor = Post::with('user', 'markedUsers')
            ->where('user_id', '=', $user->id)
            ->get();
        return response($postsWithAuthor);
    }

    public function Subscribe()
    {
        //TODO
    }

    //Done
    public function GetPostsByHashtag($hashtag)
    {
        $newHashTag = Hashtag::where('name', $hashtag)->first();
        $posts = Hashtag::find($newHashTag->id)->posts()->with('user', 'hashtags')->get();

        return response()->json($posts);
    }
}
