<?php

namespace TheCodingMachine\CMS\Theme;


class TwigThemeTest extends AbstractThemeTestCase
{
    public function testTwigTheme()
    {
        $twigTheme = new TwigTheme($this->createTwigEnvironment(), 'index.html');

        $stream = $twigTheme->render(['name' => 'Foo']);

        $this->assertSame('Hello Foo!', $stream->getContents());
    }
}
