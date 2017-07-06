<?php

namespace TheCodingMachine\CMS\Page;


use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Uri;

class StaticPageRegistryTest extends TestCase
{
    public function testStaticPageRegistry()
    {
        $page = $this->createMock(PageInterface::class);
        $registry = new StaticPageRegistry([
            '/test' => $page
        ]);

        $this->assertSame($page, $registry->getPage(new Uri('http://exemple.com/test')));
        $this->assertNull($registry->getPage(new Uri('http://exemple.com/test2')));
    }
}
