<?php

namespace App\Module\Generator;

use App\Module\Helper\ScoreGenerator;

class DivisionLeagueGenerator implements ILeagueGenerator
{
    /**
     * TODO метод конечно длинный, но я уж не стал его разбивать на более мелкие. Разбил в другом классе, чтобы показать, что умею. (Р. Мартин конечно осудил бы)
     *
     * @param array $leagueInfoList
     * @return array
     */
    public function generate(array $leagueInfoList): array
    {
        $scoreResultList = [];

        foreach ($leagueInfoList as $divisionName => &$teamInfoList) {
            $divisionTeamIds = \array_keys($teamInfoList);

            foreach ($teamInfoList as $teamId => &$teamInfo) {
                if (!isset($scoreResultList[$divisionName][$teamId])) {
                    $scoreResultList[$divisionName][$teamId]['scoreResult'] = 0;
                }

                // Создаем зеркальные массивы с результатами матчей и добавляем их в инфу по командам
                foreach ($divisionTeamIds as $divisionTeamId) {
                    if (!isset($scoreResultList[$divisionName][$divisionTeamId])) {
                        $scoreResultList[$divisionName][$divisionTeamId]['scoreResult'] = 0;
                    }

                    if ($teamId == $divisionTeamId) {
                        $teamInfo['scores'][$divisionTeamId] = null;
                    } elseif (!isset($teamInfo['scores'][$divisionTeamId])) {
                        $randScore = ScoreGenerator::getScore();

                        $teamInfo['scores'][$divisionTeamId] = $randScore;
                        $scoreResultList[$divisionName][$teamId]['scoreResult'] += $randScore;
                        $teamInfoList[$divisionTeamId]['scores'][$teamId] = $randScore ? 0 : 1;
                        $scoreResultList[$divisionName][$divisionTeamId]['scoreResult'] += ($randScore ? 0 : 1);
                    }

                    $teamInfo['scoreResult'] = $scoreResultList[$divisionName][$teamId]['scoreResult'];
                    $scoreResultList[$divisionName][$teamId]['teamId'] = $teamId;
                }
            }
        }

        return $leagueInfoList;
    }
}