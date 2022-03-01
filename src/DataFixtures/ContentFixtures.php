<?php

namespace App\DataFixtures;

use App\Entity\Content;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ContentFixtures extends Fixture
{
    public const LOCALES = [
        'fr' => 'FR',
        'en' => 'EN',
        'ru' => 'RU',
        'ja' => 'JP',
        'de' => 'DE',
    ];

    public function load(ObjectManager $manager): void
    {
        $fakerFR = Factory::create('fr_FR');
        $fakerEN = Factory::create('en_EN');
        $fakerRU = Factory::create('ru_RU');
        $fakerJP = Factory::create('ja_JP');
        $fakerDE = Factory::create('de_DE');
        $slugger = new AsciiSlugger();


        $content = new Content();
        $content->setPoster('https://zupimages.net/up/22/04/b2d6.jpg');
        $content->setIdentifier('presentation-du-site');
        foreach (self::LOCALES as $key => $locale) {
            $faker = 'faker' . $locale;
            $title = $$faker->realtext(45);
            $content->translate($key)->setTitle($title);
            $content->translate($key)->setBody($$faker->realtext(500));
            $content->translate($key)->setAlt($$faker->text(25));
        }
        $manager->persist($content);
        $content->mergeNewTranslations();

        $content = new Content();
        $content->setPoster('https://zupimages.net/up/22/04/ivos.jpeg');
        $content->setIdentifier('presentation-association');
        foreach (self::LOCALES as $key => $locale) {
            $faker = 'faker' . $locale;
            $title = $$faker->realtext(45);
            $content->translate($key)->setTitle($title);
            $content->translate($key)->setBody($$faker->realtext(500));
            $content->translate($key)->setAlt($$faker->text(25));
        }
        $manager->persist($content);
        $content->mergeNewTranslations();

        $content = new Content();
        $content->setIdentifier('footer');
        foreach (self::LOCALES as $key => $locale) {
            $faker = 'faker' . $locale;
            $title = $$faker->realtext(45);
            $content->translate($key)->setTitle($title);
            $content->translate($key)->setBody($$faker->realtext(500));
        }
        $manager->persist($content);
        $content->mergeNewTranslations();

        $content = new Content();
        $title = 'Politique de confidentialite';
        $content->setIdentifier('politique-de-confidentialite');
        foreach (self::LOCALES as $key => $locale) {
            $faker = 'faker' . $locale;
            $content->translate($key)->setTitle($title);
            $content->translate($key)->setBody($$faker->realtext(500));
        }
        $content->setSlug($slugger->slug(strtolower($title)));
        $manager->persist($content);
        $content->mergeNewTranslations();

        $content = new Content();
        $title = 'Mentions legales';
        $content->setIdentifier('mentions-legales');
        foreach (self::LOCALES as $key => $locale) {
            $faker = 'faker' . $locale;
            $content->translate($key)->setTitle($title);
            $content->translate($key)->setBody($$faker->realtext(500));
        }
        $content->setSlug($slugger->slug(strtolower($title)));
        $manager->persist($content);
        $content->mergeNewTranslations();

        $manager->flush();
    }
}
