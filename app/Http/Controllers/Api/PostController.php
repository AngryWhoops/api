<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use App\Models\HashtagPost;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\UserSubuser;
use App\Models\User;
use App\Services\FromArrayStringFinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //TODO
    public function GetAllMyPosts()
    {
        $subscriptinIds = User::find(1)
            ->subscriptions()->pluck('id')->toArray();

        $posts = Post::whereHas('markedUsers', function ($query) {
            $query->where('user_id', 1);
        })->orWhereIn('user_id', $subscriptinIds)->orWhere('user_id', 1);
        //Посты,где автор MyUser
        $postsWhereAuthor = User::find(1)
            ->posts()
            ->with('user')
            ->get()
            ->sortByDesc('created_at');
        //Пост, из подписок MyUser
        $postsWhereSubscriptions = User::find(1)
            ->subscriptions()
            ->with('posts')
            ->get()
            ->sortByDesc('created_at');
        //Посты, где отмечен MyUser
        $postsWhereMarked = User::find(1)
            ->markedOnPosts()
            ->with('user')
            ->get()
            ->sortByDesc('created_at');
        /* $all = $postsWhereAuthor->merge($postsWhereSubscriptions)->merge($postsWhereMarked)->sortByDesc('created_at'); */

        $posts = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->join('post_user', 'users.id', '=', 'post_user.user_id')
            ->select('users.*', 'posts.body', 'post_user.post_id')
            ->where('users.id', 2, 'and', 'post_user.id', '=', 'posts.user_id')
            ->get();

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
        /*
        Получаю массивы отмеченных пользователей
        и отмеченных хештегов из тела поста.
        */
        $usersFinder = new FromArrayStringFinder($text, '@');
        $hashtagsFinder = new FromArrayStringFinder($text, '#');
        $tagsArray = $usersFinder->Find();
        $usersArray = $hashtagsFinder->Find();
        /*
        Проверяем каждый тег на наличие в базе,
        если тега нет, то добавляем его
        и создаём связь с созданным постом.
        Если тег есть то создаём связь с созданным постом.
        */
        foreach ($tagsArray as $hashtag) {
            $tag = Hashtag::where('name', $hashtag)->first(); // переделать на wherein

            if ($tag === null) {
                $newHashtag = new Hashtag();
                $newHashtag->name = $hashtag;
                $newHashtag->save();

                $hashtagPostRelation = new HashtagPost();
                $hashtagPostRelation->fill([
                    'hashtag_id' => $newHashtag->id,
                    'post_id' => $createdPost->id
                ]);
                $hashtagPostRelation->save();
            } else {
                $hashtagPostRelation = new HashtagPost();
                $hashtagPostRelation->fill([
                    'hashtag_id' => $tag->id,
                    'post_id' => $createdPost->id
                ]);

                $hashtagPostRelation->save();
            }
        }

        /*
        Проверяем каждого юзера на наличие в базе,
        если юзера нет, то в базу НЕ заносим (видимо будем
        считать это просто текстом).Если юзер есть
        то создаём связь с созданным постом.
        */
        foreach ($usersArray as $user) {
            $userFoundFromDb = User::where('login', $user)->first();

            if (!$userFoundFromDb == null) {
                $postUserRelation = new PostUser();
                $postUserRelation->fill([
                    'post_id' => $createdPost->id,
                    'user_id' => $userFoundFromDb->id
                ]);

                $postUserRelation->save();
            }
        }
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
