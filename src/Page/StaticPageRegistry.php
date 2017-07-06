<?php


namespace TheCodingMachine\CMS\Page;


use Psr\Http\Message\UriInterface;
use TheCodingMachine\CMS\Block\BlockInterface;

class StaticPageRegistry implements PageRegistryInterface
{
    /**
     * @var array|BlockInterface[]
     */
    private $pages;

    /**
     * @param BlockInterface[] $pages An array associating the path (as key) to a Page object. The key must start with a '/'
     */
    public function __construct(array $pages)
    {
        $this->pages = $pages;
    }

    public function getPage(UriInterface $uri): ?BlockInterface
    {
        return $this->pages[$uri->getPath()] ?? null;
    }
}
