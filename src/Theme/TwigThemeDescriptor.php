<?php


namespace TheCodingMachine\CMS\Theme;


class TwigThemeDescriptor implements ThemeDescriptorInterface, \JsonSerializable
{
    /**
     * @var string
     */
    private $template;

    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    public function jsonSerialize()
    {
        return [
            'type' => 'twig',
            'template' => $this->template,
        ];
    }
}
