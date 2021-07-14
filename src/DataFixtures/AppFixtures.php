<?php

namespace App\DataFixtures;

use App\Entity\Convention;
use App\Entity\Etudiant;
use App\Helpers\HelpersTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    use HelpersTrait;

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for ($e = 0; $e < random_int(60, 90); $e++) {
            $etudiant = new Etudiant;
            $nom = $faker->lastName;
            $prenom = $faker->firstName;
            $email = strtolower("{$this->skipAccents($prenom)}.{$this->skipAccents($nom)}@mail.com");

            $etudiant->setEmail($email)
                ->setNom($nom)
                ->setPrenom($prenom)
            ;

            $manager->persist($etudiant);

            $convention = new Convention;

            $convention->setNbHeur(random_int(30, 150))
                ->setNom($faker->words(random_int(3, 6), true))
                ->addEtudiant($etudiant)
            ;

            $manager->persist($convention);
        }

        $manager->flush();
    }
}
