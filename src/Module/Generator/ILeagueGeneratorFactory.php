<?php

namespace App\Module\Generator;

interface ILeagueGeneratorFactory
{
    public function createDivisionLeagueGenerator(): ILeagueGenerator;
    public function createPlayoffLeagueGenerator(): ILeagueGenerator;
}