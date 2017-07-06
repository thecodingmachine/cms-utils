<?php

namespace TheCodingMachine\CMS\Theme;


class TwigThemeFactoryTest extends AbstractThemeTestCase
{
    public function testException()
    {
        $twigThemeFactory = new TwigThemeFactory($this->createTwigEnvironment());
        $mock = $this->createMock(ThemeDescriptorInterface::class);

        $this->expectException(CannotHandleThemeDescriptorExceptionInterface::class);
        $twigThemeFactory->createTheme($mock);
    }
}
