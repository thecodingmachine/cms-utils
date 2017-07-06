<?php
namespace TheCodingMachine\CMS\Theme;


use TheCodingMachine\CMS\RenderableInterface;

class SubThemeFactory implements ThemeFactoryInterface
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
     * Creates a theme object based on the descriptor object passed in parameter.
     *
     * @throws \TheCodingMachine\CMS\Theme\CannotHandleThemeDescriptorExceptionInterface Throws an exception if the factory cannot handle this descriptor.
     */
    public function createTheme(ThemeDescriptorInterface $descriptor): RenderableInterface
    {
        if (!$descriptor instanceof SubThemeDescriptor) {
            throw CannotHandleThemeDescriptorException::cannotHandleDescriptorClass(get_class($descriptor));
        }
        return new SubTheme($this->themeFactory->createTheme($descriptor->getThemeDescriptor()), $descriptor->getAdditionalContext());
    }

    /**
     * Returns true if this factory can handle the descriptor passed in parameter. False otherwise.
     */
    public function canCreateTheme(ThemeDescriptorInterface $descriptor): bool
    {
        return $descriptor instanceof SubThemeDescriptor;
    }
}
