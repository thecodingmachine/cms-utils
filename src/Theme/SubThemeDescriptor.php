<?php


namespace TheCodingMachine\CMS\Theme;


class SubThemeDescriptor implements ThemeDescriptorInterface, \JsonSerializable
{
    /**
     * @var mixed[]
     */
    private $additionalContext;
    /**
     * @var ThemeDescriptorInterface
     */
    private $themeDescriptor;

    /**
     * @param mixed[] $additionalContext
     */
    public function __construct(ThemeDescriptorInterface $themeDescriptor, array $additionalContext)
    {
        $this->additionalContext = $additionalContext;
        $this->themeDescriptor = $themeDescriptor;
    }

    /**
     * @return ThemeDescriptorInterface
     */
    public function getThemeDescriptor(): ThemeDescriptorInterface
    {
        return $this->themeDescriptor;
    }

    /**
     * @return mixed[]
     */
    public function getAdditionalContext(): array
    {
        return $this->additionalContext;
    }

    public function jsonSerialize()
    {
        return [
            'type' => 'subTheme',
            'additionalContext' => $this->additionalContext,
            'theme' => $this->themeDescriptor
        ];
    }

    /**
     * Returns the path of the theme.
     * This does not have to be an absolute path (it is relative to the theme directory)
     *
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->getThemeDescriptor()->getPath();
    }
}
