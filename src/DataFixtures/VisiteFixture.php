<?php

namespace App\DataFixtures;

use App\Entity\Visite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VisiteFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Création des fakers pour la génération des enregistrements aléatoires
        $faker = Factory::create('fr_FR');
        //génération des enregistrements
        for($k=0;$k<100;$k++){
            $visite = new Visite();
            $visite->setVille($faker->city);
            $visite->setPays($faker->country);
            $visite->setDatecreation($faker->dateTimeBetween('-10 years','now'));
            $visite->setTempmin($faker->numberBetween(-20,10));
            $visite->setTempmax($faker->numberBetween(10,40));
            $visite->setNote($faker->numberBetween(10, 20));
            $visite->setAvis($faker->sentence(4, true));
            //enregistrement de l'objet
            $manager->persist($visite);

        }

        $manager->flush();
    }
}
