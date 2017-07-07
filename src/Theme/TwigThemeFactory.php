<?php


namespace TheCodingMachine\CMS\Theme;


use TheCodingMachine\CMS\Block\BlockRenderer;
use TheCodingMachine\CMS\RenderableInterface;

class TwigThemeFactory implements ThemeFactoryInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var BlockRenderer
     */
    private $blockRenderer;

    public function __construct(\Twig_Environment $twig, BlockRenderer $blockRenderer)
    {
        $this->twig = $twig;
        $this->blockRenderer = $blockRenderer;
    }

    /**
     * Creates a theme object based on the descriptor object passed in parameter.
     *
     * @throws \TheCodingMachine\CMS\Theme\CannotHandleThemeDescriptorExceptionInterface Throws an exception if the factory cannot handle this descriptor.
     */
    public function createTheme(ThemeDescriptorInterface $descriptor): RenderableInterface
    {
        if (!$descriptor instanceof TwigThemeDescriptor) {
            throw CannotHandleThemeDescriptorException::cannotHandleDescriptorClass(get_class($descriptor));
        }
        return new TwigTheme($this->twig, $descriptor->getTemplate(), $this->blockRenderer);
    }

    /**
     * Returns true if this factory can handle the descriptor passed in parameter. False otherwise.
     */
    public function canCreateTheme(ThemeDescriptorInterface $descriptor): bool
    {
        return $descriptor instanceof TwigThemeDescriptor;
    }
}
