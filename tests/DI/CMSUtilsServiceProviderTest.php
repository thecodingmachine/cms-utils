<?php

namespace TheCodingMachine\CMS\DI;

use PHPUnit\Framework\TestCase;
use Simplex\Container;
use TheCodingMachine\CMS\Block\BlockRendererInterface;
use TheCodingMachine\TwigServiceProvider;

class CMSUtilsServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $container = new Container();
        $container->register(new TwigServiceProvider());
        $container->register(new CMSUtilsServiceProvider());

        $blockRenderer = $container->get(BlockRendererInterface::class);

        $this->assertInstanceOf(BlockRendererInterface::class, $blockRenderer);
    }
}
