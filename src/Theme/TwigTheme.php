<?php


namespace TheCodingMachine\CMS\Theme;

use Psr\Http\Message\StreamInterface;
use TheCodingMachine\CMS\Block\BlockInterface;
use TheCodingMachine\CMS\Block\BlockRendererInterface;
use TheCodingMachine\CMS\RenderableInterface;
use Zend\Diactoros\Stream;

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

    public function __construct(\Twig_Environment $twig, string $template, BlockRendererInterface $blockRenderer)
    {
        $this->twig = $twig;
        $this->template = $template;
        $this->blockRenderer = $blockRenderer;
    }


    /**
     * Renders (as a stream) the data passed in parameter.
     *
     * @param mixed[] $context
     * @return StreamInterface
     */
    public function render(array $context): StreamInterface
    {
        foreach ($context as $key => &$value) {
            if ($value instanceof BlockInterface) {
                $additionalContext = [
                    'parent' => $context,
                    'page' => $context['page'] ?? $context
                ];

                $value = $this->blockRenderer->renderBlock($value, $additionalContext);
            }
        }

        $text = $this->twig->render($this->template, $context);

        $stream = new Stream('php://temp', 'wb+');
        $stream->write($text);
        $stream->rewind();

        return $stream;
    }
}
