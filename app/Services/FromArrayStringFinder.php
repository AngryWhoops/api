<?php

namespace App\Services;

class FromArrayStringFinder
{
    private string $inputText;
    private $arrayStrings = [];
    private string $symbol = '';
    private $result = [];

    public function __construct(string $inputArray, string $symbol)
    {
        $this->inputText = $inputArray;
        $this->symbol = $symbol;
        $this->arrayStrings = explode(" ", $this->inputText);
    }

    /*
    Find() позволяет извлечь
    строки из входящего текста, которые начинаются
    с символа, переданного в обьект класса.
    */
    public function Find()
    {
        foreach ($this->arrayStrings as $element) {
            if ($element[0] == $this->symbol) {
                $clearedString = trim($element, $this->symbol);
                array_push($this->result, $clearedString);
            }
        };
        return $this->result;
    }
}
