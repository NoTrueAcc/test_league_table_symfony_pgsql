<?php

namespace App\Module\Generator;

class LeagueGeneratorFactory implements ILeagueGeneratorFactory
{
    public function createDivisionLeagueGenerator(): ILeagueGenerator
    {
        return new DivisionLeagueGenerator();
    }

    public function createPlayoffLeagueGenerator(): ILeagueGenerator
    {
        return new PlayoffLeagueGenerator();
    }
}