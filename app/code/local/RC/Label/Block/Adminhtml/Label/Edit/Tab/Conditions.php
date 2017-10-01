<?php

/**
 * Labels Admin Form Conditions Tab
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label_Edit_Tab_Conditions extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare the conditions tab form
     * @return type
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('label_data');
        $helper = Mage::helper('rc_label');
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('rule_');

        $renderer = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')
            ->setTemplate('promo/fieldset.phtml')
            ->setNewChildUrl($this->getUrl('*/promo_catalog/newConditionHtml/form/rule_label_conditions'));

        $conditionsFieldset = $form->addFieldset('label_conditions', array(
            'legend'=>$helper->__('Attribute Conditions (leave blank for all products)'))
        )->setRenderer($renderer);

        $conditionsFieldset->addField('conditions_serialized', 'text', array(
            'name' => 'conditions_serialized',
            'label' => $helper->__('Conditions'),
            'title' => $helper->__('Conditions'),
            'required' => true,
        ))->setRule($model)->setRenderer(Mage::getBlockSingleton('rule/conditions'));

        $timeFieldset = $form->addFieldset('label_time', array('legend' => $helper->__('Date & Time Conditions')));
        $dateFormat = 'yyyy-MM-dd HH:mm:ss';
        
        $timeFieldset->addField('date_range_status', 'select', array(
            'label' => $helper->__('Date Range Condition'),
            'name' => 'date_range_status',
            'required' => true,
            'values' => $this->getStatusOptionArray(),
        ));
        
        $timeFieldset->addField('date_from', 'datetime', array(
            'label'         => $helper->__('Label is Active From'),
            'title'         => $helper->__('Label is Active From'),
            'name'          => 'date_from',
            'style'        => 'width: 120px',
            'image'         => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format'  => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format'        => $dateFormat,
            'time'          => true,
        ));  
        
        $timeFieldset->addField('date_to', 'datetime', array(
            'label'         => $helper->__('Label is Active Until'),
            'title'         => $helper->__('Label is Active Until'),
            'name'          => 'date_to',
            'style'        => 'width: 120px',
            'image'         => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format'  => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format'        => $dateFormat,
            'time'          => true,
        ));
        
        $onSaleFieldset = $form->addFieldset('label_on_sale', array('legend' => $helper->__('On Sale & Discount Conditions')));

        $onSaleFieldset->addField('is_on_sale', 'select', array(
            'label' => $helper->__('On Sale Condition'),
            'name' => 'is_on_sale',
            'required' => true,
            'values' => $this->getStatusOptionArray(),
        ));
        
        $onSaleFieldset->addField('minimum_discount', 'text', array(
            'label' => $helper->__('Minimum Discount Allowed (%)'),
            'name' => 'minimum_discount',
        ));
        
        $onSaleFieldset->addField('maximum_discount', 'text', array(
            'label' => $helper->__('Maximum Discount Allowed (%)'),
            'name' => 'maximum_discount',
        ));
        
        $isNewFieldset = $form->addFieldset('label_is_new', array('legend' => $helper->__('New Product Conditions')));

        $isNewFieldset->addField('is_new', 'select', array(
            'label' => $helper->__('New Products Condition'),
            'name' => 'is_new',
            'required' => true,
            'values' => $this->getStatusOptionArray(),
        ));
        
        $isNewFieldset->addField('is_new_default', 'select', array(
            'label'     => $helper->__('Use Default Dates'),
            'name'      => 'is_new_default',
            'required'  => true,
            'values'    => $this->getStatusOptionArray(),
            'note'   => 'Use the dates set on the product. Note that if this option is enabled the below conditions will not be considered.',
        ));
        
        $isNewFieldset->addField('is_new_starting_date', 'datetime', array(
            'label'         => $helper->__('Product Is New Since'),
            'title'         => $helper->__('Product Is New Since'),
            'name'          => 'is_new_starting_date',
            'style'         => 'width: 120px',
            'image'         => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format'  => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format'        => $dateFormat,
            'time'          => true,
            'note'       => 'Products Created before this date will not match the condition',
        ));
        
        $isNewFieldset->addField('is_new_ending_date', 'datetime', array(
            'label'         => $helper->__('Product Is New Until'),
            'title'         => $helper->__('Product Is New Until'),
            'name'          => 'is_new_ending_date',
            'style'         => 'width: 120px',
            'image'         => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format'  => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format'        => $dateFormat,
            'time'          => true,
            'note'       => 'Products Created after this date will not match the condition',
        ));
        
        if ($model) {
            $form->setValues(Mage::registry('label_data')->getData());
        }
        $this->setForm($form);

        return parent::_prepareForm();
    }
    
    /**
     * Get status options
     * @return array
     */
    public function getStatusOptionArray()
    {
        $helper = Mage::helper('rc_label');
        
        return array(
            array(
                'value' => 0,
                'label' => $helper->__('Disabled'),
            ),
            array(
                'value' => 1,
                'label' => $helper->__('Enabled'),
            ),
        );
    }
}

