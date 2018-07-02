<?php

namespace RC\Offices\Controller\Adminhtml\Office;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Upload model
     * @var \RC\Offices\Model\Upload
     */
    protected $_uploadModel;

    /**
     * Image model
     * @var \RC\Offices\Model\Office\Image
     */
    protected $_imageModel;

    /**
     * Backend session
     * @var \Magento\Backend\Model\Session
     */
    protected $_backendSession;
    
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
     * constructor
     * 
     * @param \RC\Offices\Model\Upload $uploadModel
     * @param \RC\Offices\Model\Office\Image $imageModel
     * @param \RC\Offices\Model\OfficeFactory $officeFactory
     * @param \Magento\Backend\Model\Session $backendSession
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \RC\Offices\Model\Upload $uploadModel,
        \RC\Offices\Model\Office\Image $imageModel,
        \RC\Offices\Model\OfficeFactory $officeFactory,
        \Magento\Backend\Model\Session $backendSession,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_uploadModel = $uploadModel;
        $this->_imageModel = $imageModel;
        $this->_officeFactory = $officeFactory;
        $this->_backendSession = $backendSession;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Run the action
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost('office');
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($data) {
            $officeId = $this->getRequest()->getParam('office_id');
            $office = $this->_officeFactory->create();
        
            if ($officeId) {
                $office->load($officeId);
            }
            
            $office->setData($data);
            $this->_coreRegistry->register('rc_office_data', $office);
            
            $image = $this->_uploadModel->uploadFileAndGetName('image', $this->_imageModel->getBaseDir(), $data);
            $office->setImage($image);
            
            $this->_eventManager->dispatch(
                'rc_office_prepare_save',
                [
                    'office' => $office,
                    'request' => $this->getRequest()
                ]
            );
            
            try {
                $office->save();
                $this->messageManager->addSuccess(__('The Office has been saved.'));
                $this->_backendSession->setRcOfficeData(false);
                
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'rc/*/edit',
                        [
                            'office_id' => $office->getId(),
                            '_current' => true
                        ]
                    );
                    
                    return $resultRedirect;
                }
                
                $resultRedirect->setPath('rc/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Office.'));
            }
            
            $this->_getSession()->setRcOfficeData($data);
            $resultRedirect->setPath(
                'rc/*/edit',
                [
                    'office_id' => $office->getId(),
                    '_current' => true
                ]
            );
            return $resultRedirect;
        }
        
        $resultRedirect->setPath('rc/*/');
        return $resultRedirect;
    }
}

