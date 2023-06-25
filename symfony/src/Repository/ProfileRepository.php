<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Profile>
 *
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    private const PER_PAGE = 20;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findBySlug(string $slug): ?Profile
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder->select('u')->from($this->getEntityName(),'u')
            ->where($builder->expr()->eq('u.slug', ':slug'))
            ->setParameter('slug', $slug);
        return  $builder->getQuery()->getOneOrNullResult();
    }

    public function getProfileForServiceWithPagination(int $serviceId, int $page = 0){

        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder->select('p')->from($this->getEntityName(),'p')
            ->orderBy('p.id', 'DESC')
            ->leftJoin('p.services', 'services', 'WITH', 'services.id = :service_id')
            ->setParameter('service_id', $serviceId)
            ->setFirstResult(self::PER_PAGE * $page)
            ->setMaxResults(self::PER_PAGE);

        return $builder->getQuery()->getResult();
    }

    public function save(Profile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Profile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
