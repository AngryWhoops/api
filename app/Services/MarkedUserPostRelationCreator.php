<?php

namespace App\Services;

use App\Models\User;
use App\Models\PostUser;

/*
Проверяем каждого юзера на наличие в базе,
если юзера нет, то в базу НЕ заносим (видимо будем
считать это просто текстом).Если юзер есть
то создаём связь с созданным постом.
*/

class MarkedUserPostRelationCreator
{
    private array $usersArray;
    private $id;

    public function __construct(array $inputArray, int $postId)
    {
        $this->usersArray = $inputArray;
        $this->id = $postId;
    }

    public function FindAndCreate()
    {
        $usersFoundFromDb = User::whereIn('login', $this->usersArray)->get();
        foreach ($usersFoundFromDb as $user) {

            $postUserRelation = new PostUser();
            $postUserRelation->fill([
                'post_id' => $this->id,
                'user_id' => $user->id
            ]);

            $postUserRelation->save();
        }
    }
}
