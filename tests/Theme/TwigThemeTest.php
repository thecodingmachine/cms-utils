<?php

namespace TheCodingMachine\CMS\Theme;


use TheCodingMachine\CMS\Block\Block;
use TheCodingMachine\CMS\CMSException;

class TwigThemeTest extends AbstractThemeTestCase
{
    public function testTwigTheme()
    {
        $twigTheme = new TwigTheme($this->createTwigEnvironment(), 'index.html', $this->createBlockRenderer(), 'theme_path');

        $stream = $twigTheme->render(['name' => 'Foo']);

        $this->assertSame('Hello Foo!', $stream->getContents());
    }

    public function testSubBlocks()
    {
        $twigTheme = new TwigTheme($this->createTwigEnvironment(), 'index.html', $this->createBlockRenderer(), 'theme_path');

        $header = new Block(
            new TwigThemeDescriptor('header.html', []),
            [
                'menu' => [
                    'menu',
                    'menu2'
                ]
            ]
        );

        $stream = $twigTheme->render([
            'name' => 'Foo',
            'header' => $header
        ]);

        $this->assertSame('menumenu2FooFooHello Foo!', $stream->getContents());
    }

}
