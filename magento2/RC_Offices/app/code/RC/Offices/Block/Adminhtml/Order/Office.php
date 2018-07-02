<?php

namespace RC\Offices\Block\Adminhtml\Order;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Office extends \Magento\Sales\Block\Adminhtml\Order\AbstractOrder
{   
    /**
     * Office Factory
     * @var \RC\Offices\Model\OfficeRepository
     */
    protected $_officeRepository;
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Sales\Helper\Admin $adminHelper
     * @param \RC\Offices\Model\OfficeRepository $officeRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Helper\Admin $adminHelper,
        \RC\Offices\Model\OfficeRepository $officeRepository,
        array $data = []
    ) {
        $this->_officeRepository = $officeRepository;
        parent::__construct($context, $registry, $adminHelper, $data);
    }
    
    /**
     * Get Office name from the Order
     * @return string
     */
    public function getOfficeName()
    {
        $order = $this->getOrder();
        if ($order) {
            $officeId = $order->getRcOffice();
            if ($officeId) {
                $office = $this->_officeRepository->getById($officeId);
                return $office->getName();
            }
        }
        
        return '';
    }
}

