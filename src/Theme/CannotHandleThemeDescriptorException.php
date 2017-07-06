<?php


namespace TheCodingMachine\CMS\Theme;


use TheCodingMachine\CMS\CMSException;

class CannotHandleThemeDescriptorException extends CMSException implements CannotHandleThemeDescriptorExceptionInterface
{

    public static function cannotHandleDescriptorClass(string $themeType)
    {
        return new self(sprintf('Cannot handle the theme descriptor class "%s"', $themeType));
    }
}
