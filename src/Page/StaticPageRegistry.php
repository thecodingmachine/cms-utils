<?php


namespace TheCodingMachine\CMS\Page;


use Psr\Http\Message\ServerRequestInterface;
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

    public function getPage(ServerRequestInterface $request): ?BlockInterface
    {
        return $this->pages[$request->getUri()->getPath()] ?? null;
    }
}
