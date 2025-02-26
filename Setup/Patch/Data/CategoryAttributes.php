<?php

namespace MageOS\MetaRobotsTag\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use MageOS\MetaRobotsTag\Api\AttributesProviderInterface;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean as BooleanSource;
use Magento\Framework\Exception\LocalizedException;
use Zend_Validate_Exception;

class CategoryAttributes implements DataPatchInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetup;
    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;
    /**
     * @var AttributesProviderInterface
     */
    protected $attributesProvider;

    /**
     * @param EavSetupFactory $eavSetup
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param AttributesProviderInterface $attributesProvider
     */
    public function __construct(
        EavSetupFactory $eavSetup,
        ModuleDataSetupInterface $moduleDataSetup,
        AttributesProviderInterface $attributesProvider
    ) {
        $this->eavSetup = $eavSetup;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributesProvider = $attributesProvider;
    }

    /**
     * @return void
     * @throws LocalizedException
     * @throws Zend_Validate_Exception
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
