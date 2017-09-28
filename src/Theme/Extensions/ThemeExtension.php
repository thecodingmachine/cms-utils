<?php


namespace TheCodingMachine\CMS\Theme\Extensions;


class ThemeExtension extends \Twig_Extension
{
    /**
     * A list of theme URLs (the active one is the last one)
     *
     * @var string[]
     */
    private $themeUrls = [];

    public function pushThemeUrl(?string $themeUrl): void
    {
        $this->themeUrls[] = rtrim($themeUrl, '/').'/';
    }

    public function popThemeUrl(): ?string
    {
        return array_pop($this->themeUrls);
    }

    private function getThemeUrl(): ?string
    {
        return $this->themeUrls[count($this->themeUrls)-1];
    }


    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return \Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('theme', [$this, 'getResourceUrl']),
        ];
    }

    public function getResourceUrl(string $resource): string
    {
        return $this->getThemeUrl().$resource;
    }
}
