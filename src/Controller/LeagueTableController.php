<?php

namespace App\Controller;

use App\Entity\Result;
use App\Entity\Team;
use App\Module\Generator\ILeagueGeneratorFactory;
use App\Module\Helper\PlayoffTeamFilter;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LeagueTableController extends AbstractController
{
    /**
     * @Route("/league-table-list", name="get_league_table_list")
     */
    public function getLeagueTableList(ILeagueGeneratorFactory $leagueGeneratorFactory, EntityManagerInterface $entityManager)
    {
        $leagueTeamInfoList = $this->getLeagueTeamInfoList();
        $divisionLeagueData = $leagueGeneratorFactory->createDivisionLeagueGenerator()->generate($leagueTeamInfoList);
        $playoffTeamFullInfo = PlayoffTeamFilter::filterLeagueTeamList($divisionLeagueData, $leagueTeamInfoList);
        $playoffResultList = $leagueGeneratorFactory->createPlayoffLeagueGenerator()->generate($playoffTeamFullInfo);

        // TODO для меня лично загадка, что сохранять надо по ТЗ. Ну в сохранение я вроде умею.
        // TODO Ну и конечно я бы сохранял не тут, а например при нажатии кнопки генерации результатов, которую я конечно же не сделал.
        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->getDoctrine()->getRepository(Team::class);

        $entityManager->beginTransaction();

        try {
            $this->savePlayoffResult($playoffResultList['quarterFinal'], $teamRepository, $entityManager);
            $this->savePlayoffResult($playoffResultList['semiFinal'], $teamRepository, $entityManager);
            $finalDataForSave = $this->getFinalDataForSave($playoffResultList['final']);
            $this->savePlayoffResult($finalDataForSave, $teamRepository, $entityManager);

            $entityManager->flush();
            $entityManager->commit();
        } catch (\Throwable $e) {
            $entityManager->rollback();
        }

        return $this->render('league_table/league_table.html.twig', [
            'leagueInfoList' => $divisionLeagueData,
            'playoffInfoList' => $playoffResultList
        ]);
    }

    /**
     * TODO конечно это можно вынести в какой нить хэлпер и т.д., но контроллер пока и так худой
     *
     * @return array
     */
    private function getLeagueTeamInfoList(): array
    {
        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->getDoctrine()
            ->getRepository(Team::class);

        $teamFullInfoList = $teamRepository->getTeamFullInfoList();

        $leagueTeamInfoList = [];

        foreach ($teamFullInfoList as $teamFullInfo) {
            $leagueTeamInfoList[$teamFullInfo['divisionName']][$teamFullInfo['teamId']] = $teamFullInfo;
        }

        return $leagueTeamInfoList;
    }

    /**
     * @param $teamMatchInfoList
     * @param TeamRepository $teamRepository
     * @param EntityManagerInterface $entityManager
     */
    private function savePlayoffResult($teamMatchInfoList, TeamRepository $teamRepository, EntityManagerInterface $entityManager): void
    {
        foreach ($teamMatchInfoList as $teamMatchInfo) {
            $resultEntity = new Result();
            $resultEntity->setFirstTeam($teamRepository->find($teamMatchInfo['firstTeam']['teamId']));
            $resultEntity->setSecondTeam($teamRepository->find($teamMatchInfo['secondTeam']['teamId']));
            $resultEntity->setFirstTeamScore($teamMatchInfo['firstTeam']['score']);
            $resultEntity->setSecondTeamScore($teamMatchInfo['secondTeam']['score']);
            $entityManager->persist($resultEntity);
        }
    }

    /**
     * @param $final
     * @return array
     */
    private function getFinalDataForSave($final): array
    {
        return [
            [
                'firstTeam' => $final['winners'][0],
                'secondTeam' => $final['winners'][1],
            ],
            [
                'firstTeam' => $final['losers'][0],
                'secondTeam' => $final['losers'][1],
            ],
        ];
    }
}