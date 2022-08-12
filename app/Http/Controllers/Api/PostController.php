<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\UserSubuser;
use App\Models\User;
use App\Services\FromArrayStringFinder;
use Illuminate\Http\Request;
use App\Services\MarkedHashtagPostRelationCreator;
use App\Services\MarkedUserPostRelationCreator;

//Гуглить правила именования классов, laravel wherein, логирование запросов, php microtime, laravel репозиторий паттерн

class PostController extends Controller
{
    //TODO
    public function GetAllMyPosts()
    {
        //Все пользователи на которых подписаны ввиде ID
        $subscriptionsId = User::find(1)->subscriptions()->pluck('subuser_id')->toArray();

        $posts = Post::whereHas('markedUsers', function ($q) {
            $q->where('user_id', 1);
        })->orWhereIn('user_id', $subscriptionsId)
            ->orWhere('user_id', 1)
            ->with('user')
            ->get()
            ->sortByDesc('created_at')
            ->values();


        /* $posts = Post::whereHas('markedUsers', function ($query) {
            $query->where('user_id', 1);
        })->orWhereIn('user_id', $subscriptionsId)->orWhere('user_id', 1); */

        return response()->json($posts);
    }

    //Done
    public function CreateMyPost(Request $request)
    {
        $text = $request->get('body');

        //Записываю пост автора MyUser в базу
        $createdPost = new Post(
            array(
                'body' => $text,
                'user_id' => 1,
            )
        );
        $createdPost->save();

        $finder = new FromArrayStringFinder();
        $usersArray = $finder->Find($text, '@');
        $tagsArray = $finder->Find($text, '#');

        $creator = new MarkedHashtagPostRelationCreator();
        $creator->FindAndCreate($tagsArray, $createdPost->id);

        $createMarkedUserPostRelationCreator = new MarkedUserPostRelationCreator();
        $createMarkedUserPostRelationCreator->FindAndCreate($usersArray, $createdPost->id);

        return response('Ok', 200);
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
