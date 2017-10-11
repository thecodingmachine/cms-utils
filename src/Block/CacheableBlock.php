<?php
namespace TheCodingMachine\CMS\Block;

use TheCodingMachine\CMS\Cache\CacheableInterface;
use TheCodingMachine\CMS\Theme\ThemeDescriptorInterface;

class CacheableBlock extends Block implements CacheableInterface
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var int
     */
    private $ttl;
    /**
     * @var array
     */
    private $tags;

    /**
     * @param ThemeDescriptorInterface $themeDescriptor
     * @param mixed[] $context
     */
    public function __construct(ThemeDescriptorInterface $themeDescriptor, array $context, string $key, int $ttl, array $tags = [])
    {
        parent::__construct($themeDescriptor, $context);
        $this->key = $key;
        $this->ttl = $ttl;
        $this->tags = $tags;
    }

    public function jsonSerialize()
    {
        $json = parent::jsonSerialize();
        $json['key'] = $this->key;
        $json['ttl'] = $this->ttl;
        $json['tags'] = $this->tags;
        return $json;
    }

    /**
     * Returns the time to live of this object, in seconds.
     *
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * Returns the tags applied to this object.
     * Useful for purging all elements by a certain tag.
     *
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Returns the cache key for this object.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
