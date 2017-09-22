<?php


namespace TheCodingMachine\CMS\DI;


use Interop\Container\Factories\Alias;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;
use TheCodingMachine\CMS\Block\BlockRenderer;
use TheCodingMachine\CMS\Block\BlockRendererInterface;
use TheCodingMachine\CMS\Theme\AggregateThemeFactory;
use TheCodingMachine\CMS\Theme\SubThemeFactory;
use TheCodingMachine\CMS\Theme\ThemeFactoryInterface;
use TheCodingMachine\CMS\Theme\TwigThemeFactory;

class CMSUtilsServiceProvider implements ServiceProviderInterface
{

    public function getFactories()
    {
        return [
            AggregateThemeFactory::class => [self::class, 'createAggregateThemeFactory'],
            ThemeFactoryInterface::class => new Alias(AggregateThemeFactory::class),
            BlockRendererInterface::class => new Alias(BlockRenderer::class),
            BlockRenderer::class => [self::class, 'createBlockRenderer'],

        ];
    }

    public static function createAggregateThemeFactory(ContainerInterface $container): AggregateThemeFactory
    {
        if (self::$themeFactory === null) {
            self::$themeFactory = new AggregateThemeFactory([]);
        }
        self::$aggregateThemeFactory = new AggregateThemeFactory();

        $subThemeFactory = new SubThemeFactory(self::$aggregateThemeFactory);
        $twigThemeFactory = new TwigThemeFactory($container->get(\Twig_Environment::class), $blockRenderer);

        self::$aggregateThemeFactory->addThemeFactory($container->get(TwigThemeFactory::class));
        self::$aggregateThemeFactory->addThemeFactory($container->get(SubThemeFactory::class));
        return self::$aggregateThemeFactory;
    }

    private static $themeFactory = null;

    public static function createBlockRenderer(ContainerInterface $container): BlockRenderer
    {
        if (self::$themeFactory === null) {
            self::$themeFactory = new AggregateThemeFactory([]);
        }

        $blockRenderer = new BlockRenderer(self::$themeFactory);

        $subThemeFactory = new SubThemeFactory(self::$themeFactory);
        $twigThemeFactory = new TwigThemeFactory($container->get(\Twig_Environment::class), $blockRenderer);

        self::$themeFactory->addThemeFactory($subThemeFactory);
        self::$themeFactory->addThemeFactory($twigThemeFactory);

        return $blockRenderer;
    }

    public function getExtensions()
    {
        return [];
    }
}
