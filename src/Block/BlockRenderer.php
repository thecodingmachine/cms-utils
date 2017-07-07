<?php
namespace TheCodingMachine\CMS\Block;


use Psr\Http\Message\StreamInterface;
use TheCodingMachine\CMS\Theme\ThemeFactoryInterface;

class BlockRenderer implements BlockRendererInterface
{
    /**
     * @var ThemeFactoryInterface
     */
    private $themeFactory;

    public function __construct(ThemeFactoryInterface $themeFactory)
    {
        $this->themeFactory = $themeFactory;
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

        $context = array_merge($page->getContext(), $additionalContext);

        return $theme->render($context);
    }
}
