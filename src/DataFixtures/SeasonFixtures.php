<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Season;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i=0; $i<count(ProgramFixtures::PROGRAM); $i++){
            $maxseason = rand(2, 4);
        for($y = 0; $y < $maxseason; $y++) {
            $season = new Season();
            $season->setNumber($y+1);
            $season->setYear($faker->year());
            $season->setDescription($faker->paragraphs(2, true));
            $season->setProgram($this->getReference('program_' . $i));
            $manager->persist($season);
            $this->addReference('season_' . $i . '_' . $y, $season);
        }
        $manager->flush();
    }
    }

    public function getDependencies()
    {
        return [
          ProgramFixtures::class,
        ];
    }
}
