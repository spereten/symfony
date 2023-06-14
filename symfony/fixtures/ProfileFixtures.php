<?php
namespace DataFixtures;

use App\DTO\ProfileManagerDto;
use App\Manager\ProfileManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtures extends Fixture
{

    public function __construct(
        private readonly ProfileManager $profileManager,
        private readonly EntityManagerInterface $entityManager,
    ){}

    public function load(ObjectManager $manager): void
    {
       $faker = \Faker\Factory::create('ru_RU');
       for ($i = 1; $i <= 40; $i++){

           $attribute = [
               'email' => $faker->email(),
               'phone' => (int)$faker->e164PhoneNumber(),
               'experience' => $faker->biasedNumberBetween(1,15),
               'first_name' => $faker->lastName(),
               'last_name' => $faker->firstNameFemale(),
               'surname' => $faker->randomElement(['Генадьевна', 'Александровна', 'Валерьевна', 'Леонидовна']),
           ];

           if($i%2 === 0){
               $attribute['last_name'] = $faker->firstNameMale();
               $attribute['surname'] = $faker->randomElement(['Сергеевич', 'Анатольевич', 'Максимович', 'Денисович']);
           }

           $this->profileManager->saveProfile(new ProfileManagerDto(...$attribute), false);
       }
       $manager->flush();
    }
}
