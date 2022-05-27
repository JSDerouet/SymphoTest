<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAM = [
        ['id' => 0, 'Title' => 'My hero academia', 'Synopsis' => 'Un petiot devient puissant', 'Category' => 'Action', 'Country' => 'Japan', 'Year' => '2016', 'Poster' => 'assets/images/MHA.jpeg'],
        ['id' => 1, 'Title' => 'Violet evergarden', 'Synopsis' => 'Une poupée cherche son identité', 'Category' => 'Aventure', 'Country' => 'Japan', 'Year' => '2016', 'Poster' => 'assets/images/violetevergarden.jpeg'],
        ['id' => 2, 'Title' => 'K-on', 'Synopsis' => 'De la musique et des gateaux', 'Category' => 'Animation', 'Country' => 'Japan', 'Year' => '2016', 'Poster' => 'assets/images/kon.jpeg'],
        ['id' => 3, 'Title' => 'Overlord', 'Synopsis' => 'Un squelette pas comme les autres', 'Category' => 'Fantastique', 'Country' => 'Japan', 'Year' => '2016', 'Poster' => 'assets/images/overlord.jpeg'],
        ['id' => 4, 'Title' => 'Happy sugar life', 'Synopsis' => 'Un amour interdit', 'Category' => 'Horreur', 'Country' => 'Japan', 'Year' => '2016', 'Poster' => 'assets/images/hsl.jpeg'],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAM as $key => $serie) {
        $program = new Program();
        $program->setTitle($serie['Title']);
        $program->setSynopsis($serie['Synopsis']);
        $program->setCategory($this->getReference('category_' . $serie['Category']));
        $program->setCountry($serie['Country']);
        $program->setYear($serie['Year']);
        $program->setPoster($serie['Poster']);
        $manager->persist($program);
        $this->addReference('program_' . $serie['id'], $program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          CategoryFixtures::class,
        ];
    }
}
