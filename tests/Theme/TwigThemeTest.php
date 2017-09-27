<?php

namespace TheCodingMachine\CMS\Theme;


use TheCodingMachine\CMS\Block\Block;

class TwigThemeTest extends AbstractThemeTestCase
{
    public function testTwigTheme()
    {
        $twigTheme = new TwigTheme($this->createTwigEnvironment(), 'index.html', $this->createBlockRenderer());

        $stream = $twigTheme->render(['name' => 'Foo']);

        $this->assertSame('Hello Foo!', $stream->getContents());
    }

    public function testSubBlocks()
    {
        $twigTheme = new TwigTheme($this->createTwigEnvironment(), 'index.html', $this->createBlockRenderer());

        $header = new Block(
            new TwigThemeDescriptor('header.html', []),
            [
                'menu' => 'menu'
            ]
        );

        $stream = $twigTheme->render([
            'name' => 'Foo',
            'header' => $header
        ]);

        $this->assertSame('menuFooFooHello Foo!', $stream->getContents());
    }

}
