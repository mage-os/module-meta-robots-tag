<?php

namespace MageOS\MetaRobotsTag\Observer;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Page\Config as PageConfig;
use MageOS\MetaRobotsTag\Api\SetMetaRobotsInterface;

class SetMetaRobotsCatalog implements ObserverInterface
{
    /**
     * @param Registry $registry
     * @param PageConfig $pageConfig
     * @param SetMetaRobotsInterface $setMetaRobots
     */
    public function __construct(
        private readonly Registry $registry,
        private readonly PageConfig $pageConfig,
        private readonly SetMetaRobotsInterface $setMetaRobots
    ) {
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        $entity = $this->getCurrentCatalogEntity();

        if ($entity) {
            $actualRobots = array_map('trim', explode(',', $this->pageConfig->getRobots()));
            $robots = $this->setMetaRobots->execute($actualRobots, $entity);

            if ($robots != $actualRobots) {
                $this->pageConfig->setRobots(implode(',', $robots));
            }
        }
    }

    /**
     * @return false|Category|Product
     */
    protected function getCurrentCatalogEntity()
    {
        /** @var $category Category */
        $category = $this->registry->registry('current_category');
        if ($category) {
            return $category;
        }

        /** @var $product Product */
        $product = $this->registry->registry('current_product');
        if ($product) {
            return $product;
        }

        return false;
    }
}
