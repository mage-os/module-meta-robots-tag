<?php

namespace MageOS\MetaRobotsTag\Observer;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Page\Config as PageConfig;
use MageOS\MetaRobotsTag\Api\SetMetaRobotsInterface;
use Magento\Framework\Exception\LocalizedException;

class SetMetaRobotsCatalog implements ObserverInterface
{
    /**
     * @param Registry $registry
     * @param PageConfig $pageConfig
     * @param SetMetaRobotsInterface $setMetaRobots
     */
    public function __construct(
        protected readonly Registry $registry,
        protected readonly PageConfig $pageConfig,
        protected readonly SetMetaRobotsInterface $setMetaRobots
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
            $actualRobots = array_map('trim', explode(',', (string)$this->pageConfig->getRobots()));
            $robots = $this->setMetaRobots->execute($actualRobots, $entity);

            if ($robots != $actualRobots) {
                $this->pageConfig->setRobots(implode(',', $robots));
            }
        }
    }

    /**
     * @return Category|Product|false
     */
    protected function getCurrentCatalogEntity(): Category|Product|false
    {
        /** @var Category|null $category */
        $category = $this->registry->registry('current_category');
        if ($category) {
            return $category;
        }

        /** @var Product|null $product */
        $product = $this->registry->registry('current_product');
        if ($product) {
            return $product;
        }

        return false;
    }
}
