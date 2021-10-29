<?php

namespace App\Tests\Module\Helper;

use App\Module\Helper\PlayoffTeamFilter;
use PHPUnit\Framework\TestCase;

class PlayoffTeamFilterTest  extends TestCase
{
    public function testFilterLeagueTeamListCorrectData()
    {
        $divisionLeagueData = [
            'A' => [
                65 => [
                    'teamId' => 65,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                    'scores' => [66 => 1],
                    'scoreResult' => 65,
                ],
                66 => [
                    'teamId' => 66,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                    'scores' => [65 => 1],
                    'scoreResult' => 66,
                ],
                69 => [
                    'teamId' => 69,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                    'scores' => [66 => 1],
                    'scoreResult' => 65,
                ],
                70 => [
                    'teamId' => 70,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                    'scores' => [66 => 1],
                    'scoreResult' => 68,
                ],
                71 => [
                    'teamId' => 71,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                    'scores' => [66 => 1],
                    'scoreResult' => 65,
                ],
                73 => [
                    'teamId' => 73,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                    'scores' => [66 => 1],
                    'scoreResult' => 65,
                ]
            ],
            'B' => [
                74 => [
                    'teamId' => 74,
                    'teamName' => 'AA',
                    'divisionName' => 'B',
                    'scores' => [66 => 1],
                    'scoreResult' => 65,
                ],
                75 => [
                    'teamId' => 75,
                    'teamName' => 'AA',
                    'divisionName' => 'B',
                    'scores' => [66 => 1],
                    'scoreResult' => 66,
                ],
                76 => [
                    'teamId' => 76,
                    'teamName' => 'AA',
                    'divisionName' => 'B',
                    'scores' => [66 => 1],
                    'scoreResult' => 67,
                ],
                77 => [
                    'teamId' => 77,
                    'teamName' => 'AA',
                    'divisionName' => 'B',
                    'scores' => [66 => 1],
                    'scoreResult' => 68,
                ],
                79 => [
                    'teamId' => 79,
                    'teamName' => 'AA',
                    'divisionName' => 'B',
                    'scores' => [66 => 1],
                    'scoreResult' => 69,
                ],
                81 => [
                    'teamId' => 81,
                    'teamName' => 'AA',
                    'divisionName' => 'B',
                    'scores' => [66 => 1],
                    'scoreResult' => 70,
                ],
                90 => [
                    'teamId' => 90,
                    'teamName' => 'AA',
                    'divisionName' => 'B',
                    'scores' => [66 => 1],
                    'scoreResult' => 71,
                ],
            ],
        ];

        $leagueTeamInfoList = [
            'A' => [
                65 => [
                    'teamId' => 65,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                66 => [
                    'teamId' => 66,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                69 => [
                    'teamId' => 69,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                70 => [
                    'teamId' => 70,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                71 => [
                    'teamId' => 71,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                73 => [
                    'teamId' => 73,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
            ],
            'B' => [
                74 => [
                    'teamId' => 74,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                75 => [
                    'teamId' => 75,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                76 => [
                    'teamId' => 76,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                77 => [
                    'teamId' => 77,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                79 => [
                    'teamId' => 79,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                81 => [
                    'teamId' => 81,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                90 => [
                    'teamId' => 90,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
            ],
        ];

        $correctResult = [
            'A' => [
                70 => [
                    'teamId' => 70,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                66 => [
                    'teamId' => 66,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                65 => [
                    'teamId' => 65,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                69 => [
                    'teamId' => 69,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
            ],
            'B' => [
                77 => [
                    'teamId' => 77,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                79 => [
                    'teamId' => 79,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                81 => [
                    'teamId' => 81,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
                90 => [
                    'teamId' => 90,
                    'teamName' => 'AA',
                    'divisionName' => 'A',
                ],
            ]
        ];
        $result = PlayoffTeamFilter::filterLeagueTeamList($divisionLeagueData, $leagueTeamInfoList);

        $this->assertEquals($result, $correctResult);
    }
}