<?php

namespace MageOS\MetaRobotsTag\Model;

use Magento\Framework\DataObject;
use MageOS\MetaRobotsTag\Api\AttributesProviderInterface;
use MageOS\MetaRobotsTag\Api\SetMetaRobotsInterface;

class SetMetaRobots implements SetMetaRobotsInterface
{
    /**
     * @param AttributesProviderInterface $attributesProvider
     */
    public function __construct(
        protected readonly AttributesProviderInterface $attributesProvider
    ) {
    }

    /**
     * @param array $robots
     * @param DataObject $entity
     * @return array
     */
    public function execute(array $robots, DataObject $entity): array
    {
        foreach ($this->attributesProvider->getAttributes() as $attributeCode => $attributeLabel) {
            if (!$this->attributeIsFlaggedInEntity($entity, $attributeCode)) {
                continue;
            }

            $robots = $this->updateRobotsValue($robots, $attributeCode);
        }

        return $robots;
    }

    /**
     * @param array $robots
     * @param string $attributeCode
     * @return array
     */
    protected function updateRobotsValue(array $robots, string $attributeCode): array
    {
        $indexFollowArchive = $this->attributesProvider->getAttributeValue($attributeCode, true);
        $newValue = $this->attributesProvider->getAttributeValue($attributeCode);

        $existingIndex = $this->findCaseInsensitiveMatch($indexFollowArchive, $robots);
        if ($existingIndex !== false) {
            $robots[$existingIndex] = $newValue;
        } else {
            $robots[] = $newValue;
        }

        return $robots;
    }

    /**
     * @param DataObject $entity
     * @param string $attributeCode
     * @return bool
     */
    protected function attributeIsFlaggedInEntity(DataObject $entity, string $attributeCode): bool
    {
        return (bool)($entity->getData($attributeCode) ?? false);
    }

    /**
     * @param string $needle
     * @param array $haystack
     * @return int|string|false
     */
    protected function findCaseInsensitiveMatch(string $needle, array $haystack): int|string|false
    {
        return array_search(strtolower($needle), array_map('strtolower', $haystack));
    }
}
