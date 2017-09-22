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
            TwigThemeFactory::class => [self::class, 'createTwigThemeFactory'],
            SubThemeFactory::class => [self::class, 'createSubThemeFactory'],
            AggregateThemeFactory::class => [self::class, 'createAggregateThemeFactory'],
            ThemeFactoryInterface::class => new Alias(AggregateThemeFactory::class),
            BlockRendererInterface::class => new Alias(BlockRenderer::class),
            BlockRenderer::class => [self::class, 'createBlockRenderer'],

        ];
    }

    public static function createTwigThemeFactory(ContainerInterface $container): TwigThemeFactory
    {
        return new TwigThemeFactory($container->get(\Twig_Environment::class), $container->get(BlockRendererInterface::class));
    }

    public static function createSubThemeFactory(ContainerInterface $container): SubThemeFactory
    {
        return new SubThemeFactory($container->get(ThemeFactoryInterface::class));
    }

    public static function createAggregateThemeFactory(ContainerInterface $container): AggregateThemeFactory
    {
        return new AggregateThemeFactory();
    }

    public static function createBlockRenderer(ContainerInterface $container): BlockRenderer
    {
        return new BlockRenderer($container->get(ThemeFactoryInterface::class));
    }

    public function getExtensions()
    {
        return [
            AggregateThemeFactory::class => [self::class, 'extendAggregateThemeFactory'],
        ];
    }

    public static function extendAggregateThemeFactory(ContainerInterface $container, AggregateThemeFactory $aggregateThemeFactory): AggregateThemeFactory
    {
        $aggregateThemeFactory->addThemeFactory($container->get(TwigThemeFactory::class));
        $aggregateThemeFactory->addThemeFactory($container->get(SubThemeFactory::class));
    }
}
