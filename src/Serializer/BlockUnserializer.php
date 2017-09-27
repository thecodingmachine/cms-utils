<?php


namespace TheCodingMachine\CMS\Serializer;

use TheCodingMachine\CMS\Block\Block;

/**
 * Class in charge of creating a block from a JSON message.
 */
class BlockUnserializer
{
    /**
     * @var ThemeUnserializerInterface
     */
    private $themeUnserializer;

    public function __construct(ThemeUnserializerInterface $themeUnserializer)
    {
        $this->themeUnserializer = $themeUnserializer;
    }

    /**
     * @param mixed[] $arr
     * @return Block
     */
    public function createFromArray(array $arr): Block
    {
        $context = $arr['context'];
        $themeDescriptor = $this->themeUnserializer->createFromArray($arr['theme']);

        return new Block($themeDescriptor, $context);
    }

}