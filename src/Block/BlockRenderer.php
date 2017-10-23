<?php
namespace TheCodingMachine\CMS\Block;


use Psr\Http\Message\StreamInterface;
use TheCodingMachine\CMS\Theme\ThemeFactoryInterface;
use TheCodingMachine\CMS\Utils\ContextMerger;
use TheCodingMachine\CMS\Utils\ContextMergerInterface;

class BlockRenderer implements BlockRendererInterface
{
    /**
     * @var ThemeFactoryInterface
     */
    private $themeFactory;
    /**
     * @var ContextMergerInterface
     */
    private $contextMerger;

    public function __construct(ThemeFactoryInterface $themeFactory, ContextMergerInterface $contextMerger = null)
    {
        $this->themeFactory = $themeFactory;
        $this->contextMerger = $contextMerger ?: new ContextMerger();
    }


    /**
     * Renders a block.
     *
     * @param BlockInterface $page
     * @param mixed[] $additionalContext
     * @return StreamInterface
     */
    public function renderBlock(BlockInterface $page, array $additionalContext = []): StreamInterface
    {
        $theme = $this->themeFactory->createTheme($page->getThemeDescriptor());

        $context = $this->contextMerger->mergeContexts($page->getContext(), $additionalContext);

        return $theme->render($context);
    }
}
