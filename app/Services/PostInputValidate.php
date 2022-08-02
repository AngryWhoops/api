<?php

namespace App\Services;
/*
PostInputValidate класс позволяет извлечь
различные данные из входящего текста (поста).
*/


//Гуглить правила именования классов, laravel wherein, логирование запросов, php microtime, laravel репозиторий паттерн
class PostInputValidate
{
    private string $inputText;
    private $arrayStrings = [];
    private $tagsArray = [];
    private $usersArray = [];

    public function __construct(string $text)
    {
        $this->inputText = $text;
        $this->arrayStrings = explode(" ", $this->inputText);
    }

    /*
    UserFilter() извлекает из исходного текста поста
    пользователей, отмеченных в тексте символом '@'.
    Возвращает массив пользователей типа String.
    */
    public function UserFilter()
    {
        foreach ($this->arrayStrings as $element) {
            if ($element[0] == '@') {
                $clearedString = trim($element, "@");
                array_push($this->usersArray, $clearedString);
            }
        };

        return $this->usersArray;
    }

    /*
    TagFilter() извлекает из исходного текста поста
    хештеги (слова), отмеченные в тексте символом '#'.
    Возвращает массив хештегов типа String.
    */
    public function TagFilter()
    {
        foreach ($this->arrayStrings as $element) {
            if ($element[0] == '#') {
                $clearedString = trim($element, "#");
                array_push($this->tagsArray, $clearedString);
            }
        };

        return $this->tagsArray;
    }
}
