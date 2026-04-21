<?php

namespace MageOS\MetaRobotsTag\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean as BooleanSource;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use MageOS\MetaRobotsTag\Api\AttributesProviderInterface;
use Magento\Framework\Exception\LocalizedException;

class CategoryAttributes implements DataPatchInterface
{
    /**
     * @param EavSetupFactory $eavSetup
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param AttributesProviderInterface $attributesProvider
     */
    public function __construct(
        protected readonly EavSetupFactory $eavSetup,
        protected readonly ModuleDataSetupInterface $moduleDataSetup,
        protected readonly AttributesProviderInterface $attributesProvider
    ) {
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $eavSetup = $this->eavSetup->create(['setup' => $this->moduleDataSetup]);

        foreach ($this->attributesProvider->getAttributes() as $attributeCode => $attributeLabel) {
            $eavSetup->addAttribute(Category::ENTITY, $attributeCode, [
                'type' => 'int',
                'label' => $attributeLabel,
                'input' => 'boolean',
                'source' => BooleanSource::class,
                'visible' => true,
                'default' => '0',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Search Engine Optimization',
                'visible_on_front' => true,
                'user_defined' => false
            ]);
        }
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}
