<?php


namespace TheCodingMachine\CMS\Theme;


use Psr\Http\Message\StreamInterface;
use TheCodingMachine\CMS\RenderableInterface;

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
     * @param RenderableInterface $theme
     * @param mixed[] $additionalContext
     */
    public function __construct(RenderableInterface $theme, array $additionalContext)
    {
        $this->theme = $theme;
        $this->additionalContext = $additionalContext;
    }

    /**
     * Renders (as a stream) the data passed in parameter.
     *
     * @param mixed[] $context
     * @return StreamInterface
     */
    public function render(array $context): StreamInterface
    {
        return $this->theme->render(array_merge($this->additionalContext, $context));
    }
}
