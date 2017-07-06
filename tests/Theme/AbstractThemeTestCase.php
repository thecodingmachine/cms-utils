<?php


namespace TheCodingMachine\CMS\Theme;


use PHPUnit\Framework\TestCase;

abstract class AbstractThemeTestCase extends TestCase
{
    protected function createTwigEnvironment(): \Twig_Environment
    {
        $loader = new \Twig_Loader_Array([
            'index.html' => 'Hello {{ name }}!',
        ]);

        return new \Twig_Environment($loader);
    }
}