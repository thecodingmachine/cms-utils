<?php

namespace TheCodingMachine\CMS\Page;


use PHPUnit\Framework\TestCase;
use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;

class PageTest extends TestCase
{
    public function testPage()
    {
        $themeDescriptor = $this->createMock(ThemeDescriptorInterface::class);
        $context = ['foo'=>'bar'];

        $page = new Page(
            $themeDescriptor,
            $context
        );

        $this->assertSame($themeDescriptor, $page->getThemeDescriptor());
        $this->assertSame($context, $page->getContext());
    }
}
