<?php

namespace App\DataFixtures;

use App\Entity\CarCategory;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $generator  = Factory::create("fr_FR");
        $generator->addProvider(new \Faker\Provider\Fakecar($generator));

        $categories = $manager->getRepository(CarCategory::class)->findAll();

        for ($i = 0; $i <= 25; $i++) {
            $car = new Car();
            $car->setNbSeats($generator->vehicleSeatCount())
                ->setNbDoors($generator->vehicleDoorCount())
                ->setName($generator->vehicle())
                ->setCost($generator->numberBetween(50000, 200000))
                ->setCategory($generator->randomElement($categories));

            $manager->persist($car);
        }
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CarCategoryFixtures::class];
    }
}
