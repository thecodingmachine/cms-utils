<?php

namespace TheCodingMachine\CMS\Page;


use PHPUnit\Framework\TestCase;
use TheCodingMachine\CMS\Block\BlockInterface;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;

class StaticPageRegistryTest extends TestCase
{
    public function testStaticPageRegistry()
    {
        $page = $this->createMock(BlockInterface::class);
        $registry = new StaticPageRegistry([
            '/test' => $page
        ]);

        $this->assertSame($page, $registry->getPage(new ServerRequest([], [], new Uri('http://exemple.com/test'))));
        $this->assertNull($registry->getPage(new ServerRequest([], [], new Uri('http://exemple.com/test2'))));
    }
}
