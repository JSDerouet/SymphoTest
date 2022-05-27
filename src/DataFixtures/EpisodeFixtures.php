<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Episode;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i = 0; $i < count(ProgramFixtures::PROGRAM); $i++){
            $program = $this->getReference('program_' . $i);
            $numseasons = count($program->getSeasons());
            for($y = 0; $y < $numseasons; $y++){
                $maxepisodes = rand(12, 24);
                for($z = 0; $z < $maxepisodes; $z++) {
                    $episode = new Episode();
                    $episode->setNumber($z+1);
                    $episode->setTitle($faker->sentence(4, true));
                    $episode->setSynopsis($faker->paragraphs(4, true));
                    $episode->setSeason($this->getReference('season_' . $i . '_' . $y));
                    $manager->persist($episode);
        }
        $manager->flush();
    }
    }
}

    public function getDependencies()
    {
        return [
          SeasonFixtures::class,
        ];
    }
}
