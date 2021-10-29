<?php

namespace App\Repository;

use App\Entity\Division;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function getTeamFullInfoList()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('
                             t.id as teamId,
                             t.teamName as teamName,
                             d.divisionName as divisionName
                             ')
            ->innerJoin('t.division', 'd', Join::WITH);

        return $queryBuilder->getQuery()
                            ->getArrayResult();
    }
}