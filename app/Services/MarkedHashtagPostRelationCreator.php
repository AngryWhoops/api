<?php

namespace App\Services;

use App\Models\Hashtag;
use App\Models\HashtagPost;
/*
Проверяем каждый тег на наличие в базе,
если тега нет, то добавляем его
и создаём связь с созданным постом. Теги уникальны.
Если тег есть то создаём связь с созданным постом.
*/

class MarkedHashtagPostRelationCreator
{
    private $hashtagsArray;
    private int $id;

    public function __construct(array $inputArray, int $postId)
    {
        $this->hashtagsArray = $inputArray;
        $this->id = $postId;
    }

    public function FindAndCreate()
    {
        foreach ($this->hashtagsArray as $tag) {
            $foundedHashtag = Hashtag::where('name', $tag)->first();

            if ($foundedHashtag === null) {
                $newHashtag = new Hashtag();
                $newHashtag->name = $tag;
                $newHashtag->save();

                $hashtagPostRelation = new HashtagPost();
                $hashtagPostRelation->fill([
                    'hashtag_id' => $newHashtag->id,
                    'post_id' => $this->id
                ]);
                $hashtagPostRelation->save();
            } else {
                $hashtagPostRelation = new HashtagPost();

                $hashtagPostRelation->fill([
                    'hashtag_id' => $foundedHashtag->id,
                    'post_id' => $this->id
                ]);

                $hashtagPostRelation->save();
            }
        }
    }
}
