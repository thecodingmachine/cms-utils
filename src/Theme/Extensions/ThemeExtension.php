<?php


namespace TheCodingMachine\CMS\Theme\Extensions;


class ThemeExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    private $themeUrl;

    public function __construct(string $themeUrl)
    {

        $this->themeUrl = rtrim($themeUrl, '/').'/';
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return \Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('theme', [$this, 'getThemeUrl']),
        ];
    }

    public function getThemeUrl(string $resource): string
    {
        return $this->themeUrl.$resource;
    }
}