<?php

namespace TheCodingMachine\CMS\Theme;


use PHPUnit\Framework\TestCase;

class SubThemeDescriptorTest extends TestCase
{
    public function testGetPath()
    {
        $descriptor = new TwigThemeDescriptor('index.twig', [
            'theme' => '/foo/'
        ]);

        $subDescriptor = new SubThemeDescriptor($descriptor, []);

        $this->assertSame('foo/', $subDescriptor->getPath());
    }
}
