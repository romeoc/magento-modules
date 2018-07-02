<?php

namespace RC\Offices\Controller\Adminhtml\Office;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Backend session
     * @var \Magento\Backend\Model\Session
     */
    protected $_backendSession;

    /**
     * Page factory
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Result JSON factory
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;
    
    /**
     * Office Factory
     * @var \RC\Offices\Model\OfficeFactory
     */
    protected $_officeFactory;
    
    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Constructor
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\Session $backendSession
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \RC\Offices\Model\OfficeFactory $officeFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\Session $backendSession,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \RC\Offices\Model\OfficeFactory $officeFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->_backendSession  = $backendSession;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_officeFactory = $officeFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * ACL Settings
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('RC_Offices::Offices');
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $officeId = $this->getRequest()->getParam('office_id');
        $office = $this->_officeFactory->create();
        
        if ($officeId) {
            $office->load($officeId);
        }

        $this->_coreRegistry->register('rc_office_data', $office);
        
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('RC_Offices::Offices');
        $resultPage->getConfig()->getTitle()->set(__('Offices'));
        
        if ($officeId && (!$office || !$office->getId())) {
            $this->messageManager->addError(__('This Office no longer exists.'));
            $resultRedirect = $this->_resultRedirectFactory->create();
            $resultRedirect->setPath(
                'rc_office/*/edit',
                [
                    'office_id' => $office->getId(),
                    '_current' => true
                ]
            );

            return $resultRedirect;
        }
        
        $title = $office->getId() ? $office->getName() : __('New Office');
        $resultPage->getConfig()->getTitle()->prepend($title);
        $data = $this->_backendSession->getData('rc_office_data', true);
        
        if (!empty($data)) {
            $office->setData($data);
        }
        
        return $resultPage;
    }
}
