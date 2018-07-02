<?php

namespace RC\Offices\Observer;

/**
 * RC Office Observer Model
 * @event sales_model_service_quote_submit_before
 */
class BeforeQuoteSubmit implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\DataObject\Copy $objectCopyService
     */
    protected $_objectCopyService;
    
    public function __construct(
        \Magento\Framework\DataObject\Copy $objectCopyService
    ) {
        $this->_objectCopyService = $objectCopyService;
    }

    /**
     * Address before save event handler
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getQuote();
        $customer = $quote->getCustomer();
        $order = $observer->getOrder();
        
        if ($customer && $customer->getId()) {
            $this->copyOfficeFields($customer, $quote, $order);
        }
    }
    
    /**
     * Copy fieldsets
     * 
     * Some explanation: Seems that we cannot use "copyFieldsetToTarget" between a
     * customer and quote object because there are some missing attributes on the
     * customer at this state. Of course we could re-load the object, but that would
     * affect the performance of the store and really isn't mandatory at this point
     * since we can just manually set the attribute
     * 
     * @param $customer \Magento\Quote\Api\Data\CustomerInterface
     * @param $quote \Magento\Quote\Api\Data\CartInterface
     * @param $order \Magento\Sales\Api\Data\Order
     */
    protected function copyOfficeFields($customer, $quote, $order)
    {
        $office = $customer->getCustomAttribute('rc_office');
        
        if ($office && $office->getValue()) {
            $quote->setData('rc_office', $office->getValue());
            $this->_objectCopyService->copyFieldsetToTarget('sales_convert_quote', 'to_order', $quote, $order);
        }
    }
}
