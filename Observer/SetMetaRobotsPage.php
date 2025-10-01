<?php

namespace MageOS\MetaRobotsTag\Observer;

use Magento\Cms\Model\Page;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Page\Config as PageConfig;
use MageOS\MetaRobotsTag\Api\SetMetaRobotsInterface;

class SetMetaRobotsPage implements ObserverInterface
{
    /**
     * @param PageConfig $pageConfig
     * @param SetMetaRobotsInterface $setMetaRobots
     */
    public function __construct(
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
        /** @var $page Page */
        $page = $observer->getEvent()->getData('page');

        $actualRobots = array_map('trim', explode(',', $this->pageConfig->getRobots()));
        $robots = $this->setMetaRobots->execute($actualRobots, $page);

        if ($robots != $actualRobots) {
            $this->pageConfig->setRobots(implode(',', $robots));
        }
    }
}
