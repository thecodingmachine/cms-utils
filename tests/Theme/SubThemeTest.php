<?php

namespace TheCodingMachine\CMS\Theme;


class SubThemeTest extends AbstractThemeTestCase
{
    public function testSubTheme()
    {
        $twigTheme = new TwigTheme($this->createTwigEnvironment(), 'index.html', $this->createBlockRenderer(), 'theme');

        $subTheme = new SubTheme($twigTheme, ['name' => 'Foo']);

        $stream = $subTheme->render([]);
        $this->assertSame('Hello Foo!', $stream->getContents());

        $stream = $subTheme->render(['name' => 'Bar']);
        $this->assertSame('Hello Bar!', $stream->getContents(), 'Passed context overrides context of the constructor.');
    }
}
