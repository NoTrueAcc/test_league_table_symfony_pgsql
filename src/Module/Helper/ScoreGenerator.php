<?php

namespace App\Module\Helper;

class ScoreGenerator
{
    public static function getScore(): int
    {
        return rand(0, 1);
    }
}