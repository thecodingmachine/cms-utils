<?php


namespace TheCodingMachine\CMS\Utils;


interface ContextMergerInterface
{
    /**
     * Merges 2 contexts in a custom way.
     *
     * @param mixed[] $context1
     * @param mixed[] $context2
     * @return mixed[]
     */

    public function mergeContexts(array $context1, array $context2): array;
}