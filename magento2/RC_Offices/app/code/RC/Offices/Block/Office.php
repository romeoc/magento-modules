<?php

namespace RC\Offices\Block;

use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Office extends \Magento\Framework\View\Element\Template
{   
    /**
     * @var \Magento\Framework\App\Cache\Type\Config
     */
    protected $_configCacheType;

    /**
     * Office Dropdown options
     * @var \RC\Offices\Model\ResourceModel\Office\CollectionFactory
     */
    protected $_officeCollectionFactory;
    
    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    protected $serializer;
    
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\Cache\Type\Config $configCacheType
     * @param \RC\Offices\Model\ResourceModel\Office\Collection $officeCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Cache\Type\Config $configCacheType,
        \Magento\Customer\Model\Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        \RC\Offices\Model\ResourceModel\Office\CollectionFactory $officeCollectionFactory,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->_configCacheType = $configCacheType;
        $this->_officeCollectionFactory = $officeCollectionFactory;
        parent::__construct($context, $data);
    }
    
    /**
     * @param null|string $defaultValue
     * @param string $name
     * @param string $id
     * @param string $title
     * @return string
     */
    public function getOfficesHtmlSelect()
    {
        $customer = $this->getCustomer();

        $defaultValue = null;
        if ($customer) {
            $officeAttribute = $customer->getCustomAttribute('rc_office');
            if ($officeAttribute) {
                $defaultValue = $officeAttribute->getValue();
            }
        }
        
        $cache = $this->_configCacheType->load(\RC\Offices\Model\Office::CACHE_TAG);
        if ($cache) {
            $options = $this->getSerializer()->unserialize($cache);
        } else {
            $collection = $this->_officeCollectionFactory->create();
            $options = $collection->toOptionArray();
            
            $this->_configCacheType->save(
                $this->getSerializer()->serialize($options), 
                \RC\Offices\Model\Office::CACHE_TAG
            );
        }
        
        return $this->getLayout()->createBlock(\Magento\Framework\View\Element\Html\Select::class)
            ->setName('rc_office')
            ->setId('office_id')
            ->setTitle(__('Office'))
            ->setValue($defaultValue)
            ->setOptions($options)
            ->getHtml();
    }
    
    /**
     * Get serializer
     * @return \Magento\Framework\Serialize\SerializerInterface
     */
    protected function getSerializer()
    {
        if ($this->serializer === null) {
            $this->serializer = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Framework\Serialize\SerializerInterface::class);
        }
        
        return $this->serializer;
    }
    
    /**
     * Return the Customer given the customer ID stored in the session.
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomer()
    {
        $customerId = $this->customerSession->getCustomerId();
        
        if ($customerId) {
            return $this->customerRepository->getById($customerId);
        }
        
        return null;
    }
}

