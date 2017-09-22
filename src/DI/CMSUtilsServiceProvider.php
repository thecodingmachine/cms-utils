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
        $aggregateThemeFactory = null;
        return [
            AggregateThemeFactory::class => function(ContainerInterface $container) use (&$aggregateThemeFactory): AggregateThemeFactory
            {
                if ($aggregateThemeFactory === null) {
                    $aggregateThemeFactory = new AggregateThemeFactory([]);
                } else {
                    return $aggregateThemeFactory;
                }
                $aggregateThemeFactory = new AggregateThemeFactory();

                $subThemeFactory = new SubThemeFactory($aggregateThemeFactory);
                $twigThemeFactory = new TwigThemeFactory($container->get(\Twig_Environment::class), $container->get(BlockRendererInterface::class));

                $aggregateThemeFactory->addThemeFactory($twigThemeFactory);
                $aggregateThemeFactory->addThemeFactory($subThemeFactory);
                return $aggregateThemeFactory;
            },
            ThemeFactoryInterface::class => new Alias(AggregateThemeFactory::class),
            BlockRendererInterface::class => new Alias(BlockRenderer::class),
            BlockRenderer::class => function(ContainerInterface $container) use (&$aggregateThemeFactory): BlockRenderer
            {
                if ($aggregateThemeFactory === null) {
                    $aggregateThemeFactory = new AggregateThemeFactory([]);
                }

                $blockRenderer = new BlockRenderer($aggregateThemeFactory);

                $subThemeFactory = new SubThemeFactory($aggregateThemeFactory);
                $twigThemeFactory = new TwigThemeFactory($container->get(\Twig_Environment::class), $blockRenderer);

                $aggregateThemeFactory->addThemeFactory($subThemeFactory);
                $aggregateThemeFactory->addThemeFactory($twigThemeFactory);

                return $blockRenderer;
            },

        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
