<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\ArticleCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\AsciiSlugger;
use SymfonyBundles\Slugify\Slugify;

class ArticleCategoryFixtures extends Fixture
{
    public const CATEGORYNUMS = 4;
    public const LOCALES = [
        'fr' => 'FR',
        'en' => 'EN',
        'de' => 'DE',
        'ja' => 'JP',
        'ru' => 'RU'
    ];

    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();
        $fakerFactory = Factory::create();
        $fakerFR = Factory::create('fr_FR');
        $fakerEN = Factory::create('en_EN');
        $fakerDE = Factory::create('de_DE');
        $fakerJP = Factory::create('ja_JP');
        $fakerRU = Factory::create('ru_RU');
        for ($i = 0; $i < self::CATEGORYNUMS; $i++) {
            $articleCategory = new ArticleCategory();
            foreach (self::LOCALES as $key => $locale) {
                $faker = 'faker' . $locale;
                $name = $$faker->realtext(45);
                $articleCategory->translate($key)->setName($name);
                $slugger->setLocale($key);
                $articleCategory->translate($key)->setSlug($slugger->slug($name));
            }
                $this->addReference('articleCategory_' . $i, $articleCategory);
                $manager->persist($articleCategory);
                $articleCategory->mergeNewTranslations();
        }
        $manager->flush();
    }
}
