<?php

namespace App\Repository;

use App\Entity\Flight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Flight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flight[]    findAll()
 * @method Flight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flight::class);
    }

    public function getByDates(string $from, string $to, string $dateFrom, string $dateTo)
    {
        $dateTimeFrom = \DateTime::createFromFormat('d/m/Y H:i', $dateFrom . ' 00:00');
        $dateTimeTo = \DateTime::createFromFormat('d/m/Y H:i', $dateTo . ' 23:59');

        return $this->createQueryBuilder('f')
            ->where('f.from = :from and f.to = :to and f.departureTime >= :dateTimeFrom and f.departureTime <= :dateTimeTo')
            ->setParameters([
                'from' => $from,
                'to' => $to,
                'dateTimeFrom' => $dateTimeFrom,
                'dateTimeTo' => $dateTimeTo
            ])
            ->orderBy('f.price', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
