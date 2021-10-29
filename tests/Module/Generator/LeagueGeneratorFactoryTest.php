<?php

namespace App\Tests\Module\Generator;

use App\Module\Generator\DivisionLeagueGenerator;
use App\Module\Generator\LeagueGeneratorFactory;
use App\Module\Generator\PlayoffLeagueGenerator;
use PHPUnit\Framework\TestCase;

class LeagueGeneratorFactoryTest extends TestCase
{
    public function testCreateDivisionLeagueGenerator()
    {
        $result = (new LeagueGeneratorFactory())->createDivisionLeagueGenerator();

        $this->assertInstanceOf(DivisionLeagueGenerator::class, $result);
    }

    public function testCreatePlayoffLeagueGenerator()
    {
        $result = (new LeagueGeneratorFactory())->createPlayoffLeagueGenerator();

        $this->assertInstanceOf(PlayoffLeagueGenerator::class, $result);
    }
}