<?php


namespace TheCodingMachine\CMS\Serializer;


use TheCodingMachine\CMS\CMSException;
use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;

class AggregateThemeUnserializer implements ThemeUnserializerInterface
{
    /**
     * @var ThemeUnserializerInterface[]
     */
    private $unserializers;

    /**
     * @param ThemeUnserializerInterface[] $unserializers
     */
    public function __construct(array $unserializers = [])
    {
        $this->unserializers = $unserializers;
    }

    public function addUnserializer(string $type, ThemeUnserializerInterface $unserializer) : void
    {
        $this->unserializers[$type] = $unserializer;
    }

    public function createFromArray(array $arr): ThemeDescriptorInterface
    {
        if (!isset($arr['type'])) {
            throw new CMSException('Missing type key in theme.');
        }
        $type = $arr['type'];
        if (!isset($this->unserializers[$type])) {
            throw new CMSException('Unknown theme type: '.$type);
        }

        return $this->unserializers[$type]->createFromArray($arr);
    }
}