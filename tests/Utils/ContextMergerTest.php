<?php

namespace TheCodingMachine\CMS\Utils;

use PHPUnit\Framework\TestCase;

class ContextMergerTest extends TestCase
{
    public function testMergeContexts()
    {
        $context1 = [
            'a' => 1,
            'b' => 2,
            'c' => [
                'foo'
            ],
            'd' => [
                'bar' => 'baz'
            ],
        ];

        $context2 = [
            'a' => 1,
            'c' => [
                'foo'
            ],
            'd' => [
                'bar' => 'fiz'
            ],
            'e' => 3
        ];

        $contextMerger = new ContextMerger();
        $result = $contextMerger->mergeContexts($context1, $context2);

        $this->assertSame([
            'a' => 1,
            'b' => 2,
            'c' => [
                'foo',
                'foo'
            ],
            'd' => [
                'bar' => 'fiz'
            ],
            'e' => 3
        ], $result);
    }
}
