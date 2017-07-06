<?php


namespace TheCodingMachine\CMS\Page;


use Psr\Http\Message\UriInterface;

class StaticPageRegistry implements PageRegistryInterface
{
    /**
     * @var array|PageInterface[]
     */
    private $pages;

    /**
     * @param PageInterface[] $pages An array associating the path (as key) to a Page object. The key must start with a '/'
     */
    public function __construct(array $pages)
    {
        $this->pages = $pages;
    }

    public function getPage(UriInterface $uri): ?PageInterface
    {
        return $this->pages[$uri->getPath()] ?? null;
    }
}
