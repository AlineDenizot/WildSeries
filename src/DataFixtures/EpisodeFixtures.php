<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('us_US');

        for ($i = 0; $i <= 150; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->text($maxNbChars = 50));

            $title = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($title);

            $episode->setNumber(($faker->numberBetween(1,10)));
            $episode->setSynopsis($faker->text);
            $episode->setSeason($this->getReference('season_' . $i % 18));
            $manager->persist($episode);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

}