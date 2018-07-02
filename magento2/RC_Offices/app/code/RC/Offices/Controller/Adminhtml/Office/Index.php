<?php

namespace RC\Offices\Controller\Adminhtml\Office;

class Index extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory  = false;
    protected $_resultPage; 

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * Call page factory to render layout and page content
     */
    public function execute()
    {
        $this->_setPageData();
        return $this->getResultPage();
    }

    /*
     * Check permission via ACL resource
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('RC_Offices::Offices');
    }

    /**
     * Fetch or generate the result page
     */
    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }
        return $this->_resultPage;
    }

    /**
     * Set active menu, page title and breadcrumbs
     * @return $this
     */
    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu('RC_Offices::Offices');
        $resultPage->getConfig()->getTitle()->prepend(__('Offices'));

        $resultPage->addBreadcrumb(__('RC'), __('RC'));
        $resultPage->addBreadcrumb(__('Offices'), __('Manage Offices'));

        return $this;
    }
}

