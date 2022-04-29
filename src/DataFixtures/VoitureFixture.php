<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VoitureFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        {
            $faker = Factory::create('fr');
            for ($i = 0; $i < 20; $i++) {
                $voiture = new Voiture();
                $voiture->setMatricule("Matricule$i");
                $voiture->setMarque("Marque $i");
                $voiture->setColor($faker->colorName);
                $manager->persist($voiture);
            }
            $manager->flush();
        }
    }
}
