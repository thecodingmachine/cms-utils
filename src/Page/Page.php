<?php
namespace TheCodingMachine\CMS\Page;

use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;

class Page implements PageInterface
{
    /**
     * @var ThemeDescriptorInterface
     */
    private $themeDescriptor;
    /**
     * @var mixed[]
     */
    private $context;

    /**
     * @param ThemeDescriptorInterface $themeDescriptor
     * @param mixed[] $context
     */
    public function __construct(ThemeDescriptorInterface $themeDescriptor, array $context)
    {

        $this->themeDescriptor = $themeDescriptor;
        $this->context = $context;
    }

    /**
     * @return ThemeDescriptorInterface
     */
    public function getThemeDescriptor(): ThemeDescriptorInterface
    {
        return $this->themeDescriptor;
    }

    /**
     * @return \mixed[]
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
