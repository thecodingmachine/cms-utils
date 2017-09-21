<?php

namespace TheCodingMachine\CMS\Theme;


class SubThemeFactoryTest extends AbstractThemeTestCase
{
    public function testSubThemeFactoryException()
    {
        $twigThemeFactory = new TwigThemeFactory($this->createTwigEnvironment(), $this->createBlockRenderer());

        $subThemeFactory = new SubThemeFactory($twigThemeFactory);
        $mock = $this->createMock(ThemeDescriptorInterface::class);

        $this->assertFalse($subThemeFactory->canCreateTheme($mock));

        $this->expectException(CannotHandleThemeDescriptorExceptionInterface::class);
        $subThemeFactory->createTheme($mock);
    }

    public function testSubThemeFactory()
    {
        $twigThemeFactory = new TwigThemeFactory($this->createTwigEnvironment(), $this->createBlockRenderer());

        $subThemeFactory = new SubThemeFactory($twigThemeFactory);

        $subThemeDescriptor = new SubThemeDescriptor(
            new TwigThemeDescriptor('index.html'),
            ['name' => 'Foo']
        );

        $this->assertTrue($subThemeFactory->canCreateTheme($subThemeDescriptor));

        $theme = $subThemeFactory->createTheme($subThemeDescriptor);
        $this->assertInstanceOf(SubTheme::class, $theme);
        $this->assertSame('Hello Foo!', $theme->render([])->getContents());
    }
}
