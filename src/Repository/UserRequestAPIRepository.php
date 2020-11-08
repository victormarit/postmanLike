<?php

namespace App\Repository;

use App\Entity\UserRequestAPI;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserRequestAPI|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserRequestAPI|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserRequestAPI[]    findAll()
 * @method UserRequestAPI[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRequestAPIRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserRequestAPI::class);
    }

    // /**
    //  * @return UserRequestAPI[] Returns an array of UserRequestAPI objects
    //  */

    public function findByExampleField($value)
    {
        //$req = $this->createQueryBuilder('u')
        //    ->where('u.user_id = :val')
        //    ->setParameter('val', $value)
        //    ->getQuery()
        //    ->getResult()
        //;

        //return $req;
    }

    public function findUserAPI($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT api.id, api.name, api.description, api.url, api.methode
        from user_request_api, user, api 
        where user_id_id = :identifient;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([':identifient' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }
}
