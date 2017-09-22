<?php


namespace TheCodingMachine\CMS\Theme;


class SubThemeDescriptor implements ThemeDescriptorInterface
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
}
