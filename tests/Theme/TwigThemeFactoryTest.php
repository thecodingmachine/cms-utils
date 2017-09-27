<?php

namespace TheCodingMachine\CMS\Theme;


class TwigThemeFactoryTest extends AbstractThemeTestCase
{
    public function testException()
    {
        $twigThemeFactory = new TwigThemeFactory($this->createTwigEnvironment(), $this->createBlockRenderer(), __DIR__.'/../Fixtures/', '/root_url');
        $mock = $this->createMock(ThemeDescriptorInterface::class);

        $this->expectException(CannotHandleThemeDescriptorExceptionInterface::class);
        $twigThemeFactory->createTheme($mock);
    }

    public function testThemeManagement()
    {
        $twigThemeFactory = $this->getTwigThemeFactory();

        $descriptor = new TwigThemeDescriptor('index.twig', ['theme' => 'foo']);

        $twigTheme = $twigThemeFactory->createTheme($descriptor);
        $result = (string) $twigTheme->render([]);

        $this->assertSame('/root_url/foo/bar.js', $result);
    }
}
