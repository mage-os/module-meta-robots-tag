<?php

namespace MageOS\MetaRobotsTag\Model;

use MageOS\MetaRobotsTag\Api\SetMetaRobotsInterface;
use MageOS\MetaRobotsTag\Api\AttributesProviderInterface;
use Magento\Framework\DataObject;

class SetMetaRobots implements SetMetaRobotsInterface
{
    /**
     * @var AttributesProviderInterface
     */
    protected $attributesProvider;

    /**
     * @param AttributesProviderInterface $attributesProvider
     */
    public function __construct(
        AttributesProviderInterface $attributesProvider
    ) {
        $this->attributesProvider = $attributesProvider;
    }

    /**
     * @param array $robots
     * @param DataObject $entity
     * @return array
     */
    public function execute(array $robots, DataObject $entity): array
    {
        foreach ($this->attributesProvider->getAttributes() as $attributeCode => $attributeLabel) {
            $indexFollowArchive = $this->attributesProvider->getAttributeValue($attributeCode, true);

            if ($this->attributeIsFlaggedInEntity($entity, $attributeCode)) {
                if ($this->myInArray($indexFollowArchive, $robots) !== false) {
                    $robots[$this->myInArray($indexFollowArchive, $robots)] = $this->attributesProvider->getAttributeValue($attributeCode);
                } else {
                    $robots[] = $this->attributesProvider->getAttributeValue($attributeCode);
                }
            }
        }

        return $robots;
    }

    /**
     * @param DataObject $entity
     * @param $attributeCode
     * @return bool
     */
    protected function attributeIsFlaggedInEntity(DataObject $entity, $attributeCode): bool
    {
        return $entity->getData($attributeCode) ?? false;
    }

    /**
     * @param $needle
     * @param $haystack
     * @return false|int|string
     */
    protected function myInArray($needle, $haystack)
    {
        return array_search(strtolower($needle), array_map('strtolower', $haystack));
    }
}
