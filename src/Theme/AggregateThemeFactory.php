<?php


namespace TheCodingMachine\CMS\Theme;


use TheCodingMachine\CMS\RenderableInterface;

class AggregateThemeFactory implements ThemeFactoryInterface
{
    /**
     * @var array|ThemeFactoryInterface[]
     */
    private $themeFactories;

    /**
     * @param ThemeFactoryInterface[] $themeFactories
     */
    public function __construct(array $themeFactories)
    {
        $this->themeFactories = $themeFactories;
    }

    /**
     * Creates a theme object based on the descriptor object passed in parameter.
     * Throws an exception if the factory cannot handle this type of descriptor.
     *
     * @throws \TheCodingMachine\CMS\Theme\CannotHandleThemeDescriptorExceptionInterface
     */
    public function createTheme(ThemeDescriptorInterface $descriptor): RenderableInterface
    {
        foreach ($this->themeFactories as $themeFactory) {
            if ($themeFactory->canCreateTheme($descriptor)) {
                return $themeFactory->createTheme($descriptor);
            }
        }
        throw CannotHandleThemeDescriptorException::cannotHandleDescriptorClass(get_class($descriptor));
    }

    /**
     * Returns true if this factory can handle the descriptor passed in parameter. False otherwise.
     */
    public function canCreateTheme(ThemeDescriptorInterface $descriptor): bool
    {
        foreach ($this->themeFactories as $themeFactory) {
            if ($themeFactory->canCreateTheme($descriptor)) {
                return true;
            }
        }
        return false;
    }
}
