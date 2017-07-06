<?php

namespace TheCodingMachine\CMS\Block;


use PHPUnit\Framework\TestCase;
use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;

class BlockTest extends TestCase
{
    public function testBlock()
    {
        $themeDescriptor = $this->createMock(ThemeDescriptorInterface::class);
        $context = ['foo'=>'bar'];

        $page = new Block(
            $themeDescriptor,
            $context
        );

        $this->assertSame($themeDescriptor, $page->getThemeDescriptor());
        $this->assertSame($context, $page->getContext());
    }
}
