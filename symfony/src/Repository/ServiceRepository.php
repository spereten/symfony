<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Gedmo\Tree\Hydrator\ORM\TreeObjectHydrator;
/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends NestedTreeRepository
{
    public const HYDRATE_TREE = 'tree';

    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $em->getConfiguration()->addCustomHydrationMode(self::HYDRATE_TREE, TreeObjectHydrator::class);

    }

    public function getTreeServices(int $maxLevel = 2): array
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('s')
            ->from($this->getEntityName(), 's')
            ->orderBy('s.root, s.left', 'ASC')
            ->where('s.level <= :level')
            ->setParameter('level', $maxLevel)
        ;

        return $query->getQuery()->setHint(\Doctrine\ORM\Query::HINT_INCLUDE_META_COLUMNS, true)->getResult(self::HYDRATE_TREE);

    }

    public function save(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
