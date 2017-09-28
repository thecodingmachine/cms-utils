<?php


namespace TheCodingMachine\CMS\Theme;


use TheCodingMachine\CMS\Block\BlockRendererInterface;
use TheCodingMachine\CMS\RenderableInterface;
use TheCodingMachine\CMS\Theme\Extensions\ThemeExtension;

class TwigThemeFactory implements ThemeFactoryInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var BlockRendererInterface
     */
    private $blockRenderer;
    /**
     * @var string
     */
    private $themesPath;
    /**
     * @var string
     */
    private $themesUrl;

    public function __construct(\Twig_Environment $twig, BlockRendererInterface $blockRenderer, string $themesPath, string $themesUrl)
    {
        $this->twig = $twig;
        $this->blockRenderer = $blockRenderer;
        $this->themesPath = rtrim($themesPath, '/').'/';
        $this->themesUrl = rtrim($themesUrl, '/').'/';
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

        // Let's configure / customize the Twig environment!
        $config = $descriptor->getConfig();
        if (isset($config['theme'])) {
            $twig = clone $this->twig;
            $twig->setLoader(new \Twig_Loader_Filesystem($this->themesPath.ltrim($config['theme'], '/')));
            $themeUrl = $this->themesUrl.ltrim($config['theme'], '/');
        } else {
            $twig = $this->twig;
            $themeUrl = null;
        }

        return new TwigTheme($twig, $descriptor->getTemplate(), $this->blockRenderer, $themeUrl);
    }

    /**
     * Returns true if this factory can handle the descriptor passed in parameter. False otherwise.
     */
    public function canCreateTheme(ThemeDescriptorInterface $descriptor): bool
    {
        return $descriptor instanceof TwigThemeDescriptor;
    }
}
