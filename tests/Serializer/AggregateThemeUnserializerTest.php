<?php

namespace TheCodingMachine\CMS\Serializer;


use PHPUnit\Framework\TestCase;
use TheCodingMachine\CMS\CMSException;

class AggregateThemeUnserializerTest extends TestCase
{
    public function testException()
    {
        $unserializer = new AggregateThemeUnserializer();
        $this->expectException(CMSException::class);
        $unserializer->createFromArray([]);
    }

    public function testException2()
    {
        $unserializer = new AggregateThemeUnserializer();
        $this->expectException(CMSException::class);
        $unserializer->createFromArray(['type'=>'not_exist']);
    }
}
