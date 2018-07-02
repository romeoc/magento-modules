<?php

namespace RC\Offices\Block\Adminhtml\Office\Edit\Tab;

class Office extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    
    /**
     * Origin Dropdown options
     * 
     * @var \RC\Offices\Model\Attribute\Source\Origin
     */
    protected $_officeOriginOptions;
    
    /**
     * Constructor
     * 
     * @param \RC\Offices\Model\Attribute\Source\Origin $officeOriginOptions
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \RC\Offices\Model\Attribute\Source\Origin $officeOriginOptions,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        $this->_officeOriginOptions = $officeOriginOptions;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    
    /**
     * Prepare form
     * @return $this
     */
    protected function _prepareForm()
    {
        $office = $this->_coreRegistry->registry('rc_office_data');
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('office_');
        $form->setFieldNameSuffix('office');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Office Information'),
                'class'  => 'fieldset-wide'
            ]
        );
        
        $fieldset->addType('image', 'RC\Offices\Block\Adminhtml\Office\Helper\Image');
        if ($office->getId()) {
            $fieldset->addField(
                'office_id',
                'hidden',
                ['name' => 'office_id']
            );
        }
        
        $fieldset->addField(
            'name',
            'text',
            [
                'name'  => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );
        
        $fieldset->addField(
            'description',
            'textarea',
            [
                'name'  => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
            ]
        );
       
        $fieldset->addField(
            'image',
            'image',
            [
                'name'  => 'image',
                'label' => __('Image'),
                'title' => __('Image'),
            ]
        );
        
        $fieldset->addField(
            'origin',
            'select',
            [
                'name'  => 'origin',
                'label' => __('Origin'),
                'title' => __('Origin'),
                'values' => $this->_officeOriginOptions->toOptionArray(),
            ]
        );

        $officeData = $this->_session->getData('rc_office_data', true);
        if ($officeData) {
            $office->addData($officeData);
        }
        
        $form->addValues($office->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     * @return string
     */
    public function getTabLabel()
    {
        return __('Office');
    }

    /**
     * Prepare title for tab
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}

