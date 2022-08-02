<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use App\Models\HashtagPost;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\UserSubuser;
use App\Models\User;
use App\Services\PostInputValidate;
use Illuminate\Http\Request;

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



    //Done
    public function CreateMyPost(Request $request)
    {
        $text = $request->get('body');

        //Записываю пост автора MyUser в базу
        $newPost = new Post(
            array(
                'body' => $text,
                'user_id' => 1,
            )
        );
        $newPost->save();
        /*
        Получаю массивы отмеченных пользователей
        и отмеченных хештегов из тела поста.
        */
        $filter = new PostInputValidate($text);
        $tagsArray = $filter->TagFilter();
        $usersArray = $filter->UserFilter();
        /*
        Проверяем каждый тег на наличие в базе,
        если тега нет, то добавляем
        и создаём связь с созданным постом.
        Если тег есть то создаём связь с созданным постом.
        */
        foreach ($tagsArray as $hashtag) {
            $tag = Hashtag::where('name', $hashtag)->first();

            if ($tag === null) {
                $newHashtag = new Hashtag();
                $newHashtag->name = $hashtag;
                $newHashtag->save();

                $hashtagPostRelation = new HashtagPost();
                $hashtagPostRelation->fill([
                    'hashtag_id' => $newHashtag->id,
                    'post_id' => $newPost->id
                ]);
                $hashtagPostRelation->save();
            } else {
                $hashtagPostRelation = new HashtagPost();
                $hashtagPostRelation->fill([
                    'hashtag_id' => $tag->id,
                    'post_id' => $newPost->id
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
                    'post_id' => $newPost->id,
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
