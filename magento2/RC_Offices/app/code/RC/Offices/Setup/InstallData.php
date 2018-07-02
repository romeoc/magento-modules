<?php

namespace RC\Offices\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
* @codeCoverageIgnore
*/
class InstallData implements InstallDataInterface
{
    /**
     * Customer setup factory
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;
    
    
    /**
     * Quote setup factory
     * @var QuoteSetupFactory
     */
    private $quoteSetupFactory;

    /**
     * Sales setup factory
     * @var SalesSetupFactory
     */
    private $salesSetupFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory,
        \Magento\Quote\Setup\QuoteSetupFactory $quoteSetupFactory,
        \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
        $this->salesSetupFactory = $salesSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /* Customer Attribute */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'rc_office',
            [
                'type' => 'int',
                'label' => 'RC Office',
                'input' => 'select',
                'source' => 'RC\Offices\Model\Attribute\Source\Office',
                'required' => false,
                'sort_order' => 100,
                'visible' => true,
                'system' => false
            ]
        );
        
        /* Forms in which the customer attribute is used in */
        $attribute = $customerSetup->getEavConfig()->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'rc_office');
        $attribute->setData(
            'used_in_forms',
            [
                'adminhtml_checkout', 
                'adminhtml_customer', 
                'customer_account_create', 
                'customer_account_edit', 
                'checkout_register'
            ]
        );
        
        $attribute->save();
        
        /* Quote Attribute */
        $quoteSetup = $this->quoteSetupFactory->create(['setup' => $setup]);
        $quoteSetup->addAttribute(
            'quote',
            'rc_office', 
            [
                'type' => 'int',
                'label' => 'RC Office',
                'input' => 'select',
                'source' => 'RC\Offices\Model\Attribute\Source\Office',
                'visible' => false, 
                'required' => false
            ]
        );
        
        /* Order Attribute */
        $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);
        $salesSetup->addAttribute(
            \Magento\Sales\Model\Order::ENTITY,
            'rc_office', 
            [
                'type' => 'int',
                'label' => 'RC Office',
                'input' => 'select',
                'source' => 'RC\Offices\Model\Attribute\Source\Office',
                'visible' => false, 
                'required' => false
            ]
        );
    }
}
