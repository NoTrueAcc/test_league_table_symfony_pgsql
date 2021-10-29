<?php

namespace App\Tests\Module\Helper;

use App\Module\Helper\ScoreGenerator;
use PHPUnit\Framework\TestCase;

class ScoreGeneratorTest extends TestCase
{
    public function testGetScore()
    {
        $this->assertContains(ScoreGenerator::getScore(), [0, 1]);
    }
}