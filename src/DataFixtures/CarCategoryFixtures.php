<?php

namespace App\DataFixtures;

use App\Entity\CarCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Factory::create("fr_FR");
        $generator->addProvider(new \Faker\Provider\Fakecar($generator));

        for ($i = 0; $i <=4; $i++) {
            $carCategory = new CarCategory();
            $carCategory->setName($generator->vehicleType())
                        ->setDescription($generator->text());

            $manager->persist($carCategory);
        }
        $manager->flush();
    }
}
