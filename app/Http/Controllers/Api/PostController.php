<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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

    //Done
    public function GetPostsByUser($login)
    {
        $user = User::where('login', $login)->first();
        //Посты, где пользователь автор
        $postsWithAuthor = Post::with('user')
            ->where('user_id', '=', $user->id)
            ->get();

        //Посты, где пользователь отмечен
        $markedOnPosts = $user
            ->markedOnPosts()
            ->with('markedUsers', 'user')
            ->get();
        /* $firstCollection = new Collection($postsWithAuthor);
        $secondCollection = new Collection($markedOnPosts); */

        //Объединяем
        $merged = $postsWithAuthor->merge($markedOnPosts);

        return response()->json($merged);
    }
    //Done
    public function SubscribeOnPost($id)
    {
        $post = Post::find($id);
        $post->subscribed_user_id = 1;
        $post->save();
    }

    //Done
    public function GetPostsByHashtag($hashtag)
    {
        $newHashTag = Hashtag::where('name', $hashtag)->first();
        $posts = Hashtag::find($newHashTag->id)->posts()->with('user', 'hashtags')->get();

        return response()->json($posts);
    }
}
