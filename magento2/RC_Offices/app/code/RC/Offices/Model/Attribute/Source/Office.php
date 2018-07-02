<?php

namespace RC\Offices\Model\Attribute\Source;

class Office extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Office Dropdown options
     * @var \RC\Offices\Model\ResourceModel\Office\CollectionFactory
     */
    protected $_officeCollectionFactory;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\Cache\Type\Config $configCacheType
     * @param \RC\Offices\Model\ResourceModel\Office\CollectionFactory $officeCollectionFactory
     * @param array $data
     */
    public function __construct(
        \RC\Offices\Model\ResourceModel\Office\CollectionFactory $officeCollectionFactory
    ) {
        $this->_officeCollectionFactory = $officeCollectionFactory;
    }
    
    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $collection = $this->_officeCollectionFactory->create();
            $this->_options = $collection->toOptionArray();
        }
        
        return $this->_options;
    }
}

