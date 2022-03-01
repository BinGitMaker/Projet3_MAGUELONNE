<?php

namespace App\DataFixtures;

use Becklyn\Slug\Generator\SlugGenerator;
use Symfony\Component\String\Slugger\AsciiSlugger;
use DateTime;
use Faker\Factory;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use SymfonyBundles\Slugify\Slugify;

class ArticleFixtures extends Fixture
{
    public const ARTICLENUMS = 0;
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
        for ($i = 0; $i < self::ARTICLENUMS; $i++) {
            $article = new Article();
            foreach (self::LOCALES as $key => $locale) {
                $faker = 'faker' . $locale;
                $title = $$faker->realtext(45);
                $article->translate($key)->setTitle($title);
                $slugger->setLocale($key);
                $article->translate($key)->setSlug($slugger->slug($title));
                $article->translate($key)->setSummary($$faker->realtext(150));
                $article->translate($key)->setBody($$faker->realtext(500));
                $article->translate($key)->setAlt($$faker->text(25));
            }

            $article->setPoster('https://fakeimg.pl/350x200/?text=article ' . $i);
            $article->setCreatedAt($fakerFactory->dateTimeBetween('-4  weeks', 'now'));
            $article->setDuration($fakerFactory->randomNumber(2));
            $article->setCategory($this->getReference('articleCategory_' . rand(1, 3)));
            $manager->persist($article);
            $article->mergeNewTranslations();
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArticleCategoryFixtures::class,
        ];
    }
}
