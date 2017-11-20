<?php

namespace TheCodingMachine\CMS\Theme;


use PHPUnit\Framework\TestCase;

class TwigThemeDescriptorTest extends TestCase
{
    public function testGetPath()
    {
        $descriptor = new TwigThemeDescriptor('index.twig', [
            'theme' => '/foo/'
        ]);

        $this->assertSame('foo/', $descriptor->getPath());

        $descriptor = new TwigThemeDescriptor('index.twig', []);

        $this->assertNull($descriptor->getPath());
    }
}
