<?php


namespace TheCodingMachine\CMS\Serializer;


use PHPUnit\Framework\TestCase;
use Simplex\Container;
use TheCodingMachine\CMS\Block\Block;
use TheCodingMachine\CMS\DI\CMSUtilsServiceProvider;
use TheCodingMachine\CMS\Theme\SubThemeDescriptor;
use TheCodingMachine\CMS\Theme\TwigThemeDescriptor;
use TheCodingMachine\TwigServiceProvider;

class BlockUnserializerTest extends TestCase
{
    public function testUnserialize()
    {
        $container = new Container();
        $container->register(new TwigServiceProvider());
        $container->register(new CMSUtilsServiceProvider());

        $blockUnserializer = $container->get(BlockUnserializer::class);
        $initialArray = [
            'context' => [
                'page' => 'Hello world'
            ],
            'theme' => [
                'type' => 'subTheme',
                'additionalContext' => [
                    'sidebar' => [
                        'bar'
                    ]
                ],
                'theme' => [
                    'type' => 'twig',
                    'template' => 'index.twig',
                    'config' => [],
                ]
            ]
        ];
        $block = $blockUnserializer->createFromArray($initialArray);

        $this->assertInstanceOf(Block::class, $block);
        $subTheme = $block->getThemeDescriptor();
        /* @var $subTheme SubThemeDescriptor */
        $this->assertInstanceOf(SubThemeDescriptor::class, $subTheme);
        $twigTheme = $subTheme->getThemeDescriptor();
        $this->assertInstanceOf(TwigThemeDescriptor::class, $twigTheme);

        $array = json_decode(json_encode($block), true);

        $this->assertEquals($initialArray, $array);
    }
}