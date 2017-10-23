<?php


namespace TheCodingMachine\CMS\Utils;


interface ContextMergerInterface
{
    public function mergeContexts(array $context1, array $context2): array;
}