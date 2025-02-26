<?php

namespace MageOS\MetaRobotsTag\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use MageOS\MetaRobotsTag\Api\AttributesProviderInterface;
use Magento\Catalog\Model\Product as ProductModel;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Exception\LocalizedException;
use Zend_Validate_Exception;

class ProductAttributes implements DataPatchInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetup;
    /**
     * @var ModuleDataSetupInterface
     */
    protected $setup;
    /**
     * @var AttributesProviderInterface
     */
    protected $attributesProvider;

    /**
     * @param EavSetupFactory $eavSetup
     * @param ModuleDataSetupInterface $setup
     * @param AttributesProviderInterface $attributesProvider
     */
    public function __construct(
        EavSetupFactory $eavSetup,
        ModuleDataSetupInterface $setup,
        AttributesProviderInterface $attributesProvider
    ) {
        $this->eavSetup = $eavSetup;
        $this->setup = $setup;
        $this->attributesProvider = $attributesProvider;
    }

    /**
     * @return void
     * @throws LocalizedException
     * @throws Zend_Validate_Exception
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
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
