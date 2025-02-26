<?php

namespace MageOS\MetaRobotsTag\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config as PageConfig;
use MageOS\MetaRobotsTag\Api\SetMetaRobotsInterface;
use Magento\Cms\Model\Page;
use Magento\Framework\Exception\LocalizedException;

class SetMetaRobotsPage implements ObserverInterface
{
    /**
     * @var PageConfig
     */
    protected $pageConfig;
    /**
     * @var SetMetaRobotsInterface
     */
    protected $setMetaRobots;

    /**
     * @param PageConfig $pageConfig
     * @param SetMetaRobotsInterface $setMetaRobots
     */
    public function __construct(
        PageConfig $pageConfig,
        SetMetaRobotsInterface $setMetaRobots
    ) {
        $this->pageConfig = $pageConfig;
        $this->setMetaRobots = $setMetaRobots;
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
