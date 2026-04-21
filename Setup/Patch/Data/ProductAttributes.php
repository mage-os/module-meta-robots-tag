<?php

namespace MageOS\MetaRobotsTag\Setup\Patch\Data;

use Magento\Catalog\Model\Product as ProductModel;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use MageOS\MetaRobotsTag\Api\AttributesProviderInterface;
use Magento\Framework\Exception\LocalizedException;

class ProductAttributes implements DataPatchInterface
{
    /**
     * @param EavSetupFactory $eavSetup
     * @param ModuleDataSetupInterface $setup
     * @param AttributesProviderInterface $attributesProvider
     */
    public function __construct(
        protected readonly EavSetupFactory $eavSetup,
        protected readonly ModuleDataSetupInterface $setup,
        protected readonly AttributesProviderInterface $attributesProvider
    ) {
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $eavSetup = $this->eavSetup->create(['setup' => $this->setup]);

        foreach ($this->attributesProvider->getAttributes() as $attributeCode => $attributeLabel) {
            $eavSetup->addAttribute(ProductModel::ENTITY, $attributeCode, [
                'label' => $attributeLabel,
                'type' => 'int',
                'input' => 'boolean',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => false,
                'unique' => false,
                'group' => 'Search Engine Optimization'
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
