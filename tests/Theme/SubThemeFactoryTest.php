<?php

namespace TheCodingMachine\CMS\Theme;


class SubThemeFactoryTest extends AbstractThemeTestCase
{
    public function testSubThemeFactoryException()
    {
        $twigThemeFactory = new TwigThemeFactory($this->createTwigEnvironment());

        $subThemeFactory = new SubThemeFactory($twigThemeFactory);
        $mock = $this->createMock(ThemeDescriptorInterface::class);

        $this->expectException(CannotHandleThemeDescriptorExceptionInterface::class);
        $subThemeFactory->createTheme($mock);
    }

    public function testSubThemeFactory()
    {
        $twigThemeFactory = new TwigThemeFactory($this->createTwigEnvironment());

        $subThemeFactory = new SubThemeFactory($twigThemeFactory);

        $subThemeDescriptor = new SubThemeDescriptor(
            new TwigThemeDescriptor('index.html'),
            ['name' => 'Foo']
        );

        $theme = $subThemeFactory->createTheme($subThemeDescriptor);
        $this->assertInstanceOf(SubTheme::class, $theme);
        $this->assertSame('Hello Foo!', $theme->render([])->getContents());
    }
}
