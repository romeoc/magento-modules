<?php

namespace RC\Offices\Controller\Adminhtml\Office;

class Delete extends \Magento\Backend\App\Action
{
    
    /**
     * Office Factory
     * 
     * @var \RC\Offices\Model\OfficeFactory
     */
    protected $_officeFactory;

    /**
     * Result redirect factory
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */
    protected $_resultRedirectFactory;
    /**
     * constructor
     * 
     * @param \RC\Offices\Model\OfficeFactory $officeFactory
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \RC\Offices\Model\OfficeFactory $officeFactory,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_officeFactory = $officeFactory;
        $this->_resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }
    
    /**
     * Execute action
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->_resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('office_id');
        
        if ($id) {
            try {
                $office = $this->_officeFactory->create();
                $office->load($id);
                $office->delete();
                
                $this->messageManager->addSuccess(__('The Office has been deleted.'));
                $resultRedirect->setPath('rc/*/');
                return $resultRedirect;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $resultRedirect->setPath('rc/*/edit', ['office_id' => $id]);
                return $resultRedirect;
            }
        }
        
        $this->messageManager->addError(__('The Office to delete was not found.'));
        $resultRedirect->setPath('rc/*/');
        return $resultRedirect;
    }
}

