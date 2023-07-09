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
1. Вопросы про проверку 404 ошибки
2. $profile = $this->profileService->getProfileBySlug($slug); вынести в тайпинг

Добрый день, возник вопрос об архитектуре, для себя выделил слои следующем образом:
1. Repository работает с базой данных
2. Manager работаю с репозиториями и конкретной сущностью
3. Service уже работают с множественными менеджерами, сущностями (?).

Теперь какая возникла проблема, задача разработать метод синхронизации профиля и услуг. Я вижу три варианта реализации:

1. Мы размещаем метод в ProfileService, в таком случае мы получаем достаточно гибкий метод. Который на вход получает: профиль (int $profileId) и список id услуг (array $services).
``
   public function syncProfileWithServices(int $profileId, array $services = []): bool
   {
       $profile = $this->profileManager->getProfileById($profileId);
       if($profile === null){
            return false;
       }
       /** @var Service[]  $services*/
       $currentServices = $profile->getServices();
       /** @var Service[]  $services*/
       $newServices = new ArrayCollection($this->serviceManager->findByCriteria(['id' => $services]));
    
        $currentServices->map(function(Service $service) use($newServices, $profile) {
            if(!$newServices->contains($service)){
                $this->profileManager->removeServiceFromProfile($profile, $service);
            }
            return $service;
        });

        $newServices->map( function(Service $service) use($currentServices, $profile) {
            if(!$currentServices->contains($service)){
                $this->profileManager->addServiceToProfile($profile, $service);
            }
            return $service;
        });
        return true;
   }
``
В целом выходит все хорошо, но т.к. мы не можем обращаться `$this->em->flush();`, приходить добавлять лишние метод в Manager
``
   public function addServiceToProfile(Profile $profile, Service $service): void
   {
       $profile->addService($service);
       $this->em->persist($profile);
       $this->em->flush();
   }
Либо как вариант выделить `$this->em->flush();` в метод и вызывать его уже из `Service`, но мы по сути даем сервису управлять EntityManager.

2. Второй вариант, мы передаем на вход сущность ($profile) и список сущностей услуг ($services). В таком случаем, мы можем метод спокойно размещать в ProfileManager, но здесь появиться другая проблема: придётся в условном контроллере сначала получить все сущности, что тоже вариант не очень

3. Третий вариант, по сути просто докручиваем второй вариант. Мы кладем в ProfileService только получение сущностей, а работу с синхронизацией кладем уже в ProfileManager

Вопрос в следующем, каким образом лучше разложить данную задачу на слои?