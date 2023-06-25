# Репозиторий для сдачи ДЗ по курсу Symfony

https://otus.ru/lessons/symfony/?utm_source=github&utm_medium=free&utm_campaign=otus
https://github.com/otusteamedu/symfony-course-2023-02
php bin/console doctrine:fixtures:load

https://profi-bel.by/backoffice/doc.php?d=vrf


php bin/console doctrine:migrations:execute DoctrineMigrations\Version20230614123204 --down

php bin/console dbal:run-sql "SELECT * FROM profile" 

profile
id, name
service
id, name
service_profile
id, service_id, profile_id
service_price
id, service_id, price


Есть несколько вопросов:
1. Оцените пожалуйста код который отправил ниже, мне необходимо добавить связь в Service, для это передаю id и получаю сущность. В этой ситуации появился вопрос лишних запросов, получается на нужно обязательно делать их, когда в том же ActiveRecord можно добавлять прямо id. Возможно есть другие решения более оптимальные.
``
   public function saveService(ServiceManagerDto $dto, bool $flush = true): Service
   {
       $entity = new Service();
       $entity->setTitle($dto->name);
       if($dto->parent){
            $entity->setParent($this->getRepository()->find($dto->parent));
       }
       $this->getRepository()->save($entity, $flush);

       return $entity;
   }
``
2. Работа с автодополнением кода, если мы получаем репозиторий `$this->em->getRepository(Service::class)`, в автодополнении нет методов созданных в репозитории мне приходить делать хак:
``
   /** @return ServiceRepository */
   private function getRepository(): \Doctrine\ORM\EntityRepository
   {
      return $this->em->getRepository(Service::class);
   }
``
Удалось найти плагин, но сейчас сложно с оплатой. Возможно есть другие варианты?

3. Для моего проекта необходима админ панель, подскажите какие варианты для решения этой задачи. В документации есть `https://github.com/EasyCorp/EasyAdminBundle`
возможно есть другие варианты. 