<?php


namespace TheCodingMachine\CMS\Theme;


use Psr\Http\Message\StreamInterface;
use TheCodingMachine\CMS\RenderableInterface;
use TheCodingMachine\CMS\Utils\ContextMerger;
use TheCodingMachine\CMS\Utils\ContextMergerInterface;

/**
 * This class is an adapter around a theme that adds additional information in the context.
 */
class SubTheme implements RenderableInterface
{
    /**
     * @var RenderableInterface
     */
    private $theme;
    /**
     * @var mixed[]
     */
    private $additionalContext;
    /**
     * @var ContextMergerInterface
     */
    private $contextMerger;

    /**
     * @param RenderableInterface $theme
     * @param mixed[] $additionalContext
     */
    public function __construct(RenderableInterface $theme, array $additionalContext, ContextMergerInterface $contextMerger = null)
    {
        $this->theme = $theme;
        $this->additionalContext = $additionalContext;
        $this->contextMerger = $contextMerger ?: new ContextMerger();
    }

    /**
     * Renders (as a stream) the data passed in parameter.
     *
     * @param mixed[] $context
     * @return StreamInterface
     */
    public function render(array $context): StreamInterface
    {
        return $this->theme->render($this->contextMerger->mergeContexts($this->additionalContext, $context));
    }
}
