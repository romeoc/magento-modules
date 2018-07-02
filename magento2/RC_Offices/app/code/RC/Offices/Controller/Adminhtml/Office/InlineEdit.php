<?php

namespace RC\Offices\Controller\Adminhtml\Office;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * JSON Factory
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_jsonFactory;

    /**
     * Office Repository
     * @var \RC\Offices\Model\OfficeRepository
     */
    protected $_officeRepository;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \RC\Offices\Model\OfficeRepository $officeRepository
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \RC\Offices\Model\OfficeRepository $officeRepository,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_officeRepository = $officeRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];
        $offices = $this->getRequest()->getParam('items', []);
        
        if (!($this->getRequest()->getParam('isAjax') && count($offices))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        
        foreach (array_keys($offices) as $officeId) {
            $office = $this->_officeRepository->getById($officeId);
            
            try {
                $office->addData($offices[$officeId]);
                $office->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithOfficeId($offices, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithOfficeId($offices, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithOfficeId(
                    $office,
                    __('Something went wrong while saving your office.')
                );
                
                $error = true;
            }
        }
        
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Office ID to error message
     *
     * @param \RC\Offices\Model\Office $office
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithOfficeId(\RC\Offices\Model\Office $office, $errorText)
    {
        return '[Office #' . $office->getId() . '] ' . $errorText;
    }
}

