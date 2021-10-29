<?php

namespace App\Module\Helper;

class PlayoffTeamFilter
{
    private const DEFAULT_TEAM_OFFSET = 0;
    private const DIVISION_TEAM_PLAYOFF_COUNT = 4;

    public static function filterLeagueTeamList($divisionLeagueData, $leagueTeamInfoList): array
    {
        $playoffLeagueData = $divisionLeagueData;
        $playoffTeamFullInfo = [];

        foreach ($playoffLeagueData as $divisionName => &$teamInfoList) {
            // Сортируем результаты команд в дивизионах, чтобы получить 4 из каждого, отсортированных в порядке уменьшения очков
            usort($teamInfoList, function($a, $b) {return $a['scoreResult'] < $b['scoreResult'];});

            $playoffTeamIds = array_column(array_slice($teamInfoList, self::DEFAULT_TEAM_OFFSET, self::DIVISION_TEAM_PLAYOFF_COUNT), 'teamId');

            foreach ($playoffTeamIds as $teamId) {
                $playoffTeamFullInfo[$divisionName][$teamId] = $leagueTeamInfoList[$divisionName][$teamId];
            }
        }

        return $playoffTeamFullInfo;
    }
}