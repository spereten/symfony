<?php

namespace App\Manager;

use App\DTO\ServiceManagerDto;
use App\Entity\Profile;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServiceManager
{
    public function __construct(private readonly EntityManagerInterface $em)
    {

    }

    public function findBySlug(string $slug): ?Service
    {
        return $this->getRepository()->findOneBy(['slug' => $slug]);
    }

    /** @return Service[] */
    public function findByCriteria(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->getRepository()->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

    /** @return Service[] */
    public function getPathService(int $serviceId): array
    {
        return $this->getRepository()->getPath($this->getRepository()->find($serviceId));
    }

    public function getTreeAllService(): array
    {
        return $this->getRepository()->getTreeServices();
    }

    public function getTreeAllServiceFromEntities(): array
    {
        $tree = $this->getTreeAllService();

        $builder = static function(&$tree) use(&$builder){
            foreach ($tree as &$node){
                if($node->getChildren()->count()){
                    $children = $node->getChildren()->toArray();
                    $node = $node->toArray();
                    $node['children'] = $builder($children);
                }else{
                    $node = $node->toArray();
                }

            }
            return $tree;
        };

        return $builder($tree);
    }

    public function saveService(ServiceManagerDto $dto, bool $flush = true): Service
    {
        $entity = new Service();
        $entity->setName($dto->name);
        if($dto->parent){
            $entity->setParent($this->getRepository()->find($dto->parent));
        }

        $this->getRepository()->save($entity, $flush);
        return $entity;
    }

    public function addProfile(Service $service, Profile $profile): void
    {
        $service->addProfile($profile);
        $this->em->persist($service);
        $this->em->flush();
    }

    /** @return ServiceRepository */
    private function getRepository(): \Doctrine\ORM\EntityRepository
    {
        return $this->em->getRepository(Service::class);
    }
}