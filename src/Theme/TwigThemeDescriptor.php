<?php


namespace TheCodingMachine\CMS\Theme;


class TwigThemeDescriptor implements ThemeDescriptorInterface, \JsonSerializable
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var mixed[]
     */
    private $config;

    /**
     * @param string $template The Twig resource to be loaded
     * @param mixed[] $config An array of configuration options that will be passed to the TwigTheme. Can be used to register parameters for the extensions, ... For instance, use the "theme" key to specify the theme used.
     */
    public function __construct(string $template, array $config)
    {
        $this->template = $template;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return mixed[]
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    public function jsonSerialize()
    {
        return [
            'type' => 'twig',
            'template' => $this->template,
            'config' => $this->config,
        ];
    }
}
