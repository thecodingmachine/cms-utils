<?php

namespace TheCodingMachine\CMS\Serializer;


use PHPUnit\Framework\TestCase;
use TheCodingMachine\CMS\Theme\TwigThemeDescriptor;

class TwigThemeUnserializerTest extends TestCase
{
    public function testUnserialize()
    {
        $unserializer = new TwigThemeUnserializer();
        $template = $unserializer->createFromArray([
            'template' => 'foo'
        ]);
        $this->assertInstanceOf(TwigThemeDescriptor::class, $template);
        $this->assertSame('foo', $template->getTemplate());
    }
}
