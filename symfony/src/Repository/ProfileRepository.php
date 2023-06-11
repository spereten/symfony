<?php

namespace App\Repository;

use App\Entity\ProfileEntity;
use App\Repository\Contract\ProfileRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @implements ProfileRepositoryInterface
 *
 * @extends ServiceRepository<ProfileEntity>
 *
 * @method ProfileEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileEntity[]    findAll()
 * @method ProfileEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)

 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfileEntity::class);
    }

    public function save(ProfileEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProfileEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



//    /**
//     * @return Profile[] Returns an array of Profile objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Profile
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
