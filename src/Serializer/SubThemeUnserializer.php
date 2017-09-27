<?php


namespace TheCodingMachine\CMS\Serializer;


use TheCodingMachine\CMS\Theme\SubThemeDescriptor;
use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;
use TheCodingMachine\CMS\Theme\TwigThemeDescriptor;

class SubThemeUnserializer implements ThemeUnserializerInterface
{
    /**
     * @var BlockUnserializer
     */
    private $blockUnserializer;
    /**
     * @var AggregateThemeUnserializer
     */
    private $aggregateThemeUnserializer;

    public function __construct(BlockUnserializer $blockUnserializer, AggregateThemeUnserializer $aggregateThemeUnserializer)
    {

        $this->blockUnserializer = $blockUnserializer;
        $this->aggregateThemeUnserializer = $aggregateThemeUnserializer;
    }

    public function createFromArray(array $arr): ThemeDescriptorInterface
    {
        $additionalContext = $arr['additionalContext'];
        foreach ($additionalContext as $key => &$value) {
            $value = $this->unserializeContextArray($value);
        }

        return new SubThemeDescriptor($this->aggregateThemeUnserializer->createFromArray($arr['theme']), $additionalContext);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function unserializeContextArray($value)
    {
        if (is_array($value)) {
            if (isset($value['context'])) {
                $value = $this->blockUnserializer->createFromArray($value);
            } else {
                foreach ($value as &$item) {
                    $item = $this->unserializeContextArray($item);
                }
            }
        }
        return $value;
    }
}
