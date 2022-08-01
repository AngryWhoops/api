<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use App\Models\HashtagPost;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\UserSubuser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function GetAllMyPosts()
    {
        //Посты,где автор MyUser
        $postsWhereAuthor = User::find(1)
            ->posts()
            ->with('user')
            ->get();
        //Пост, из подписок MyUser
        $postsWhereSubscriptions = User::find(1)
            ->subscriptions()
            ->with('posts')
            ->get();
        //Посты, где отмечен MyUser
        $postsWhereMarked = User::find(1)
            ->markedOnPosts()
            ->with('user')
            ->get();
        /* $all = $postsWhereAuthor->merge($postsWhereSubscriptions)->merge($postsWhereMarked); */


        return response()->json($postsWhereAuthor);
    }




    public function CreateMyPost(Request $request)
    {
        $text = $request->get('body');
        $arrText = explode(" ", $text);
        $tagsArray = [];
        $marksArray = [];


        foreach ($arrText as $element) {
            if ($element[0] == '#') {
                array_push($tagsArray, $element);
            } elseif ($element[0] == '@') {
                array_push($marksArray, $element);
            }
        };

        //Записываю пост
        $newPost = new Post(
            array(
                'body' => $request->get('body'),
                'user_id' => 1,
            )
        );
        $newPost->save();

        //Обреж массив с пользователям от собак
        //Записываю отношение поста с юзером (отметка юзера в посте)
        foreach ($marksArray as $user) {
            $someUser = User::where('login', $user)->first();
        }


        response()->json();
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

        //Объединяем
        $merged = $postsWithAuthor->merge($markedOnPosts);

        return response()->json($merged);
    }
    //Done
    public function SubscribeOnUser($login)
    {
        $user = User::where('login', $login)->first();

        $subscribe = new UserSubuser(
            array(
                'subuser_id' => 1,
                'user_id' => $user->id
            )
        );
        $subscribe->save();
    }

    //Done
    public function GetPostsByHashtag($hashtag)
    {
        $newHashTag = Hashtag::where('name', $hashtag)->first();
        $posts = Hashtag::find($newHashTag->id)->posts()->with('user', 'hashtags')->get();

        return response()->json($posts);
    }
}
