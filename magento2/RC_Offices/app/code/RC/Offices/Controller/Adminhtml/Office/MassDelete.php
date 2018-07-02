<?php

namespace RC\Offices\Controller\Adminhtml\Office;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Mass Action Filter
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_filter;

    /**
     * Collection Factory
     * @var \RC\Offices\Model\ResourceModel\Office\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * constructor
     * 
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \RC\Offices\Model\ResourceModel\Office\CollectionFactory $collectionFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \RC\Offices\Model\ResourceModel\Office\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }


    /**
     * execute action
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());

        $delete = 0;
        foreach ($collection as $item) {
            $item->delete();
            $delete++;
        }
        
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $delete));

        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}

