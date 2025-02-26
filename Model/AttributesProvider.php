<?php

namespace MageOS\MetaRobotsTag\Model;

use MageOS\MetaRobotsTag\Api\AttributesProviderInterface;

class AttributesProvider implements AttributesProviderInterface
{
    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return self::ATTRIBUTES;
    }

    /**
     * @param bool|string $attributeCode
     * @param bool $flag
     * @return string|string[][]
     */
    public function getAttributeValue($attributeCode = false, bool $flag = false)
    {
        return $attributeCode ? self::ATTRIBUTES_VALUE[$attributeCode][$flag] : self::ATTRIBUTES_VALUE;
    }
}
