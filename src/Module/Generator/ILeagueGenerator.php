<?php

namespace App\Module\Generator;

interface ILeagueGenerator
{
    public function generate(array $leagueInfoList): array;
}