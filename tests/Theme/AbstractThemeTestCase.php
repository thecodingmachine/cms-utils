<?php


namespace TheCodingMachine\CMS\Theme;


use PHPUnit\Framework\TestCase;
use TheCodingMachine\CMS\Block\BlockRenderer;
use TheCodingMachine\CMS\Block\BlockRendererInterface;

abstract class AbstractThemeTestCase extends TestCase
{
    protected function createTwigEnvironment(): \Twig_Environment
    {
        $loader = new \Twig_Loader_Array([
            'index.html' => '{{ header }}Hello {{ name }}!',
            'header.html' => '{{ menu }}{{ parent.name }}{{ page.name }}'
        ]);

        return new \Twig_Environment($loader);
    }

    private $twigThemeFactory;
    private $aggregateThemeFactory;

    protected function getTwigThemeFactory(): TwigThemeFactory
    {
        if ($this->twigThemeFactory !== null) {
            return $this->twigThemeFactory;
        }
        return $this->twigThemeFactory = new TwigThemeFactory($this->createTwigEnvironment(), $this->createBlockRenderer(), __DIR__.'/../Fixtures/', '/root_url');
    }

    protected function createAggregateThemeFactory(): AggregateThemeFactory
    {
        if ($this->aggregateThemeFactory !== null) {
            return $this->aggregateThemeFactory;
        }
        $this->aggregateThemeFactory = new AggregateThemeFactory([]);
        $this->aggregateThemeFactory->addThemeFactory($this->getTwigThemeFactory());
        return $this->aggregateThemeFactory;
    }


    protected function createBlockRenderer(): BlockRendererInterface
    {
        return new BlockRenderer($this->createAggregateThemeFactory());
    }
}
