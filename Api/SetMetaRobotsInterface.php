<?php

namespace MageOS\MetaRobotsTag\Api;

use Magento\Framework\DataObject;

interface SetMetaRobotsInterface
{
    /**
     * @param array $robots
     * @param DataObject $entity
     * @return array
     */
    public function execute(array $robots, DataObject $entity): array;
}
