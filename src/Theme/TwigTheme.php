<?php


namespace TheCodingMachine\CMS\Theme;

use Psr\Http\Message\StreamInterface;
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

    public function __construct(\Twig_Environment $twig, string $template)
    {
        $this->twig = $twig;
        $this->template = $template;
    }


    /**
     * Renders (as a stream) the data passed in parameter.
     *
     * @param mixed[] $context
     * @return StreamInterface
     */
    public function render(array $context): StreamInterface
    {
        $text = $this->twig->render($this->template, $context);

        $stream = new Stream('php://temp', 'wb+');
        $stream->write($text);
        $stream->rewind();

        return $stream;
    }
}
