<?php


namespace TheCodingMachine\CMS\Serializer;


use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;

interface ThemeUnserializerInterface
{
    /**
     * @param mixed[] $arr
     * @return ThemeDescriptorInterface
     */
    public function createFromArray(array $arr): ThemeDescriptorInterface;
}
