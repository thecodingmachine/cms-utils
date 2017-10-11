<?php

namespace TheCodingMachine\CMS\Block;


use PHPUnit\Framework\TestCase;
use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;

class CacheableBlockTest extends TestCase
{
    public function testCacheableBlock()
    {
        $themeDescriptor = $this->createMock(ThemeDescriptorInterface::class);
        $context = ['foo'=>'bar'];
        $ttl = 60;
        $key = 'baz';
        $tags = ['tag'];

        $page = new CacheableBlock(
            $themeDescriptor,
            $context,
            $key,
            $ttl,
            $tags
        );

        $this->assertSame($themeDescriptor, $page->getThemeDescriptor());
        $this->assertSame($context, $page->getContext());
        $this->assertSame($ttl, $page->getTtl());
        $this->assertSame($key, $page->getKey());
        $this->assertSame($tags, $page->getTags());
    }
}
