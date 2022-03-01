<?php

namespace App\DataFixtures;

use App\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventCategoryFixtures extends Fixture
{
    public const EVENT_CATEGORIES =
        [
            'Opéra',
            'Musique sacrée',
            'Musique de chambre',
            'Musique symphonique',
        ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::EVENT_CATEGORIES as $key => $eventCategoryName) {
            $eventCategory = new EventCategory();
            $eventCategory->setName($eventCategoryName);
            $eventCategory->setSlug($eventCategoryName);
            $manager->persist($eventCategory);
            $this->addReference('event_category_' . $key, $eventCategory);
        }


        $manager->flush();
    }
}
