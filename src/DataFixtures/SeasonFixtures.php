<?php


namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('us_US');

        for ($i = 0; $i < 25; $i++) {
            $season = new Season();
            $season->setProgram($this->getReference('program_'  . $i % 6));
            $season->setNumber($faker->numberBetween(1,3));
            $season->setYear($faker->numberBetween(2000, 2020));
            $season->setDescription($faker->text);
            $manager->persist($season);
            $this->addReference('season_' .$i, $season);

            $manager->flush();
        }
         
    }
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

}