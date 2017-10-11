<?php


namespace TheCodingMachine\CMS\Serializer;

use TheCodingMachine\CMS\Block\Block;
use TheCodingMachine\CMS\Block\CacheableBlock;

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

        if (isset($arr['ttl'])) {
            return new CacheableBlock($themeDescriptor, $context, $arr['key'], $arr['ttl'], $arr['tags']);
        } else {
            return new Block($themeDescriptor, $context);
        }
    }

}