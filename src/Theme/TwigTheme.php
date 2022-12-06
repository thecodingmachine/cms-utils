<?php


namespace TheCodingMachine\CMS\Theme;

use Psr\Http\Message\StreamInterface;
use TheCodingMachine\CMS\Block\BlockInterface;
use TheCodingMachine\CMS\Block\BlockRendererInterface;
use TheCodingMachine\CMS\CMSException;
use TheCodingMachine\CMS\RenderableInterface;
use TheCodingMachine\CMS\Theme\Extensions\ThemeExtension;
use Laminas\Diactoros\Stream;

class TwigTheme implements RenderableInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $template;
    /**
     * @var BlockRendererInterface
     */
    private $blockRenderer;
    /**
     * @var string
     */
    private $themeUrl;

    public function __construct(\Twig_Environment $twig, string $template, BlockRendererInterface $blockRenderer, string $themeUrl = null)
    {
        $this->twig = $twig;
        $this->template = $template;
        $this->blockRenderer = $blockRenderer;
        $this->themeUrl = $themeUrl;
    }


    /**
     * Renders (as a stream) the data passed in parameter.
     *
     * @param mixed[] $context
     * @return StreamInterface
     */
    public function render(array $context): StreamInterface
    {
        $parent = $context['parent'] ?? null;
        unset($context['parent']);
        $page = $context['page'] ?? null;
        unset($context['page']);

        foreach ($context as $key => &$value) {
            $value = $this->contextValueToString($value, $context);
        }


        if ($parent !== null) {
            $context['parent'] = $parent;
        }
        if ($page !== null) {
            $context['page'] = $page;
        }

        if (!$this->twig->hasExtension(ThemeExtension::class)) {
            $this->twig->addExtension(new ThemeExtension());
        }
        $themeExtension = $this->twig->getExtension(ThemeExtension::class);
        /* @var $themeExtension ThemeExtension */

        $themeExtension->pushThemeUrl($this->themeUrl);
        try {
            $text = $this->twig->render($this->template, $context);
        } finally {
            $themeExtension->popThemeUrl();
        }

        $stream = new Stream('php://temp', 'wb+');
        $stream->write($text);
        $stream->rewind();

        return $stream;
    }

    /**
     * @param mixed $value
     * @param mixed[] $context
     * @return string|array
     * @throws CMSException
     */
    private function contextValueToString($value, array $context)
    {
        if ($value instanceof BlockInterface) {
            $additionalContext = [
                'parent' => $context,
                'page' => $context['page'] ?? $context
            ];

            return (string) $this->blockRenderer->renderBlock($value, $additionalContext);
        }
        if (is_array($value)) {
            $value = array_map(function($item) use ($context) {
                return $this->contextValueToString($item, $context);
            }, $value);
        }
        return $value;
    }
}
