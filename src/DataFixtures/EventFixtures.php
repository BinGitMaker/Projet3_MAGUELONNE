<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public const EVENT_NB = 30;


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < self::EVENT_NB; $i++) {
            $event = new Event();
            $title = $faker->word();
            $event->setTitle($title);
            $event->setText($faker->realText());
            $event->setPoster("https://fakeimg.pl/300x300/?text=" . $title);
            $event->setAlt($faker->word);
            $event->setDate($faker->dateTimeBetween('-3 years', 'now'));
            $event->setCategory($this->getReference('event_category_0'));
            $event->setSlug($faker->text(15));
            $event->setVideo($faker->imageUrl());
            $event->setDuration($faker->numberBetween(0, 180));
            $manager->persist($event);
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventCategoryFixtures::class,
        ];
    }
}
