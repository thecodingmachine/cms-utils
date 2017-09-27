<?php


namespace TheCodingMachine\CMS\Serializer;


use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;
use TheCodingMachine\CMS\Theme\TwigThemeDescriptor;

class TwigThemeUnserializer implements ThemeUnserializerInterface
{
    public function createFromArray(array $arr): ThemeDescriptorInterface
    {
        return new TwigThemeDescriptor($arr['template'], $arr['config']);
    }
}
