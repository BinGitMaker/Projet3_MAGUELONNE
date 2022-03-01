<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\AsciiSlugger;

abstract class AbstractTranslatorController extends AbstractController
{
    public function slug(string $locale, string $name): AbstractUnicodeString
    {
        $slugger = new AsciiSlugger();
        $slugger->setLocale($locale);
        return $slugger->slug(strtolower($name));
    }
}
