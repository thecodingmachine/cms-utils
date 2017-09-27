<?php


namespace TheCodingMachine\CMS\DI;


use Interop\Container\Factories\Alias;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;
use TheCodingMachine\CMS\Block\BlockRenderer;
use TheCodingMachine\CMS\Block\BlockRendererInterface;
use TheCodingMachine\CMS\Serializer\AggregateThemeUnserializer;
use TheCodingMachine\CMS\Serializer\BlockUnserializer;
use TheCodingMachine\CMS\Serializer\SubThemeUnserializer;
use TheCodingMachine\CMS\Serializer\ThemeUnserializerInterface;
use TheCodingMachine\CMS\Serializer\TwigThemeUnserializer;
use TheCodingMachine\CMS\Theme\AggregateThemeFactory;
use TheCodingMachine\CMS\Theme\SubThemeFactory;
use TheCodingMachine\CMS\Theme\ThemeFactoryInterface;
use TheCodingMachine\CMS\Theme\TwigThemeFactory;

class CMSUtilsServiceProvider implements ServiceProviderInterface
{

    public function getFactories()
    {
        $aggregateThemeFactory = null;
        $aggregateThemeUnserializer = null;
        return [
            AggregateThemeFactory::class => function(ContainerInterface $container) use (&$aggregateThemeFactory): AggregateThemeFactory
            {
                if ($aggregateThemeFactory !== null) {
                    return $aggregateThemeFactory;
                }
                $aggregateThemeFactory = new AggregateThemeFactory([]);

                $subThemeFactory = new SubThemeFactory($aggregateThemeFactory);
                $twigThemeFactory = new TwigThemeFactory($container->get(\Twig_Environment::class), $container->get(BlockRendererInterface::class), $container->get('THEMES_PATH'), $container->get('THEMES_URL'));

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
                $twigThemeFactory = new TwigThemeFactory($container->get(\Twig_Environment::class), $blockRenderer, $container->get('THEMES_PATH'), $container->get('THEMES_URL'));

                $aggregateThemeFactory->addThemeFactory($subThemeFactory);
                $aggregateThemeFactory->addThemeFactory($twigThemeFactory);

                return $blockRenderer;
            },

            AggregateThemeUnserializer::class => function() use (&$aggregateThemeUnserializer): AggregateThemeUnserializer
            {
                list($aggregateThemeUnserializer, $blockUnserializer) = $this->getBlockAndAggregateUnserializer();


                $subThemeFactory = new SubThemeUnserializer($blockUnserializer, $aggregateThemeUnserializer);
                $twigThemeFactory = new TwigThemeUnserializer();

                $aggregateThemeUnserializer->addUnserializer('twig', $twigThemeFactory);
                $aggregateThemeUnserializer->addUnserializer('subTheme', $subThemeFactory);
                return $aggregateThemeUnserializer;
            },
            ThemeUnserializerInterface::class => new Alias(AggregateThemeUnserializer::class),
            BlockUnserializer::class => function(ContainerInterface $container) use (&$aggregateThemeUnserializer): BlockUnserializer
            {
                list($aggregateThemeUnserializer, $blockUnserializer) = $this->getBlockAndAggregateUnserializer();

                // Force resolving the aggregateThemeUnserializer
                $container->get(AggregateThemeUnserializer::class);
                return $blockUnserializer;
            },

        ];
    }

    private $aggregateThemeUnserializer;
    private $blockUnserializer;

    /**
     * This method is needed to break the loop of dependencies.
     *
     * @return mixed[]
     */
    private function getBlockAndAggregateUnserializer(): array
    {
        if ($this->aggregateThemeUnserializer) {
            return [$this->aggregateThemeUnserializer, $this->blockUnserializer];
        }

        $this->aggregateThemeUnserializer = new AggregateThemeUnserializer();
        $this->blockUnserializer = new BlockUnserializer($this->aggregateThemeUnserializer);

        return [$this->aggregateThemeUnserializer, $this->blockUnserializer];
    }

    public function getExtensions()
    {
        return [];
    }
}
