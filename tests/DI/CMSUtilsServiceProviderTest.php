<?php

namespace TheCodingMachine\CMS\DI;

use PHPUnit\Framework\TestCase;
use Simplex\Container;
use TheCodingMachine\CMS\Block\BlockRendererInterface;
use TheCodingMachine\CMS\Serializer\AggregateThemeUnserializer;
use TheCodingMachine\CMS\Serializer\BlockUnserializer;
use TheCodingMachine\TwigServiceProvider;
use TheCodingMachine\CMS\Theme\AggregateThemeFactory;

class CMSUtilsServiceProviderTest extends TestCase
{
    private function getContainer(): Container
    {
        $container = new Container();
        $container->register(new TwigServiceProvider());
        $container->register(new CMSUtilsServiceProvider());

        $container->set('THEMES_PATH', __DIR__.'/../Fixtures/');
        $container->set('THEMES_URL', '/root_url');
        return $container;
    }

    public function testServiceProvider()
    {
        $container = $this->getContainer();

        $blockRenderer = $container->get(BlockRendererInterface::class);

        $this->assertInstanceOf(BlockRendererInterface::class, $blockRenderer);
        $this->assertInstanceOf(AggregateThemeFactory::class, $container->get(AggregateThemeFactory::class));
    }

    public function testServiceProvider2()
    {
        $container = $this->getContainer();

        $this->assertInstanceOf(AggregateThemeFactory::class, $container->get(AggregateThemeFactory::class));
        $this->assertInstanceOf(BlockRendererInterface::class, $container->get(BlockRendererInterface::class));
    }

    public function testServiceProvider3()
    {
        $container = $this->getContainer();

        $this->assertInstanceOf(AggregateThemeUnserializer::class, $container->get(AggregateThemeUnserializer::class));
        $this->assertInstanceOf(BlockUnserializer::class, $container->get(BlockUnserializer::class));
    }
}
