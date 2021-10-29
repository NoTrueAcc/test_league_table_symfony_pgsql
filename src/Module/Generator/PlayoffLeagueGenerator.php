<?php

namespace App\Module\Generator;

use App\Module\Helper\ScoreGenerator;

class PlayoffLeagueGenerator implements ILeagueGenerator
{
    public function generate(array $leagueInfoList): array
    {
        $playoffResultList = [
            'quarterFinal' => [],
            'semiFinal' => [],
            'final' => [
                'winners' => [],
                'losers' => [],
            ],
        ];

        $divisionNameList = \array_keys($leagueInfoList);
        $playoffResultList['quarterFinal'] = $this->getQuarterFinalTeamMatchesInfo($leagueInfoList, $divisionNameList);
        $playoffResultList['semiFinal'] = $this->getSemiFinalTeamMatchesInfo($playoffResultList['quarterFinal'], $divisionNameList);
        $playoffResultList['final'] = $this->getFinalTeamMatchesInfo($playoffResultList['semiFinal']);

        return $playoffResultList;
    }

    /**
     * @param array $leagueInfoList
     * @param array $divisionNameList
     * @return array
     */
    private function getQuarterFinalTeamMatchesInfo(array $leagueInfoList, array $divisionNameList): array
    {
        $firstDivisionTeamIds = \array_keys($leagueInfoList[$divisionNameList[0]]);
        $secondDivisionTeamIds = \array_keys($leagueInfoList[$divisionNameList[1]]);
        $quarterFinalTeamMatchInfoList = [];

        // Собираем команды победителей в четвертьфинал, считаем, что при одинаковых очках побеждает вышестоящая команда(вот тут не понятно по ТЗ как должно быть)
        while ($firstDivisionTeamId = array_shift($firstDivisionTeamIds)) {
            $secondDivisionTeamId = array_pop($secondDivisionTeamIds);
            $randScore = ScoreGenerator::getScore();

            $quarterFinalTeamMatchInfoList[] = [
                'firstTeam' => ['teamId' => $firstDivisionTeamId, 'score' => $randScore, 'divisionName' => $divisionNameList[0]],
                'secondTeam' => ['teamId' => $secondDivisionTeamId, 'score' => $randScore ? 0 : 1, 'divisionName' => $divisionNameList[1]],
            ];
        }

        return $quarterFinalTeamMatchInfoList;
    }

    /**
     * @param $quarterFinal
     * @param array $divisionNameList
     * @return array
     */
    private function getSemiFinalTeamMatchesInfo($quarterFinal, array $divisionNameList): array
    {
        $semiFinalTeamList = [];

        // формируем команды для полуфинала
        foreach ($quarterFinal as $quarterFinalTeamMatches) {
            $semiFinalTeamList[] = $quarterFinalTeamMatches['firstTeam']['score'] ?
                ['teamId' => $quarterFinalTeamMatches['firstTeam']['teamId'], 'divisionName' => $divisionNameList[0]] :
                ['teamId' => $quarterFinalTeamMatches['secondTeam']['teamId'], 'divisionName' => $divisionNameList[1]];
        }

        $semiFinalTeamMatchInfoList = [];

        // Проводим матчи полуфинала и формируем команды для финала
        for ($i = 0; $i < \count($semiFinalTeamList); $i += 2) {
            $randScore = ScoreGenerator::getScore();

            $semiFinalTeamMatchInfoList[] = [
                'firstTeam' => ['teamId' => $semiFinalTeamList[$i]['teamId'], 'score' => $randScore, 'divisionName' => $semiFinalTeamList[$i]['divisionName']],
                'secondTeam' => ['teamId' => $semiFinalTeamList[$i + 1]['teamId'], 'score' => $randScore ? 0 : 1, 'divisionName' => $semiFinalTeamList[$i + 1]['divisionName']],
            ];
        }

        return $semiFinalTeamMatchInfoList;
    }

    /**
     * @param $semiFinal
     * @return array|array[]
     */
    private function getFinalTeamMatchesInfo($semiFinal): array
    {
        $finalTeamList = [
            'winners' => [],
            'losers' => [],
        ];

        // формируем команды для финала
        foreach ($semiFinal as $semiFinalTeamMatches) {
            if ($semiFinalTeamMatches['firstTeam']['score']) {
                $finalTeamList['winners'][] = ['teamId' => $semiFinalTeamMatches['firstTeam']['teamId'], 'divisionName' => $semiFinalTeamMatches['firstTeam']['divisionName']];
                $finalTeamList['losers'][] = ['teamId' => $semiFinalTeamMatches['secondTeam']['teamId'], 'divisionName' => $semiFinalTeamMatches['secondTeam']['divisionName']];
            } else {
                $finalTeamList['losers'][] = ['teamId' => $semiFinalTeamMatches['firstTeam']['teamId'], 'divisionName' => $semiFinalTeamMatches['firstTeam']['divisionName']];
                $finalTeamList['winners'][] = ['teamId' => $semiFinalTeamMatches['secondTeam']['teamId'], 'divisionName' => $semiFinalTeamMatches['secondTeam']['divisionName']];
            }
        }

        // проводим матчи финала
        $randScore = ScoreGenerator::getScore();

        $finalTeamList['winners'][0]['score'] = $randScore;
        $finalTeamList['winners'][1]['score'] = $randScore ? 0 : 1;

        $randScore = ScoreGenerator::getScore();

        $finalTeamList['losers'][0]['score'] = $randScore;
        $finalTeamList['losers'][1]['score'] = $randScore ? 0 : 1;

        return $finalTeamList;
    }
}