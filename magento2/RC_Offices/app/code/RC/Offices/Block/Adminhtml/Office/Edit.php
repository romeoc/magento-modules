<?php

namespace RC\Offices\Block\Adminhtml\Office;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Office Edit block
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'office_id';
        $this->_blockGroup = 'RC_Offices';
        $this->_controller = 'adminhtml_office';
        parent::_construct();
        
        $this->buttonList->update('save', 'label', __('Save Office'));
        $this->buttonList->add(
            'save-and-continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        
        $this->buttonList->update('delete', 'label', __('Delete Office'));
    }

    /**
     * Retrieve text for header element depending on loaded Post
     * @return string
     */
    public function getHeaderText()
    {
        $office = $this->_coreRegistry->registry('rc_office_data');
        
        if ($office->getId()) {
            return __("Edit Office '%1'", $this->escapeHtml($office->getName()));
        }
        
        return __('New Office');
    }
}