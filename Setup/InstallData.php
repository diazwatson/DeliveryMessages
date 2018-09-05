<?php

namespace Diazwatson\DeliveryMessages\Setup;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Boolean;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     */
    const ATTRIBUTE_CODE = 'is_next_day_delivery';
    /**
     * @var \Magento\Eav\Api\AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * InstallData constructor.
     * @param \Magento\Eav\Setup\EavSetupFactory            $eavSetupFactory
     * @param \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            $setup->startSetup();

            /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            try {
                $this->attributeRepository->get(
                    Product::ENTITY,
                    self::ATTRIBUTE_CODE
                );
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $eavSetup->addAttribute(
                    Product::ENTITY,
                    self::ATTRIBUTE_CODE,
                    [
                        'type'                    => 'varchar',
                        'label'                   => 'Is Next Day Delivery',
                        'input'                   => 'boolean',
                        'default'                 => 0,
                        'source'                  => Boolean::class,
                        'required'                => false,
                        'global'                  => ScopedAttributeInterface::SCOPE_STORE,
                        'group'                   => 'General',
                        'is_used_in_grid'         => true,
                        'used_in_product_listing' => true,
                        'visible'                 => true,
                        'is_visible_in_grid'      => true,
                        'is_filterable_in_grid'   => true,
                    ]
                );
            }
            $setup->endSetup();
        }
    }
}
