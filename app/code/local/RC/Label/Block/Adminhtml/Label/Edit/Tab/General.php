<?php

/**
 * Labels Admin Form General Tab
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare the general tab form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $helper = Mage::helper('rc_label');
        $fieldset = $form->addFieldset('label_general', array('legend' => $helper->__('General')));
        
        $fieldset->addField('name', 'text', array(
            'label' => $helper->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));
        
        $fieldset->addField('status', 'select', array(
            'label' => $helper->__('Status'),
            'name' => 'status',
            'required' => true,
            'values' => array(
                array(
                    'value' => 0,
                    'label' => $helper->__('Disabled'),
                ),
                array(
                    'value' => 1,
                    'label' => $helper->__('Active'),
                ),
            ),
        ));
        
        $fieldset->addField('priority', 'text', array(
            'label'     => $helper->__('Priority'),
            'name'      => 'priority',
        )); 
        
        $fieldset->addField('stores', 'multiselect', array(
            'label'     => $helper->__('Stores'),
            'name'      => 'stores[]',
            'class'     => 'required-entry',
            'required'  => true,
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(), 
        ));
        
        $fieldset->addField('customer_groups', 'multiselect', array(
            'name'      => 'customer_groups[]',
            'label'     => $helper->__('Customer Groups'),
            'title'     => $helper->__('Customer Groups'),
            'class'     => 'required-entry',
            'required'  => true,
            'values'    => Mage::getResourceModel('customer/group_collection')->toOptionArray()
        ));
        
        if (Mage::registry('label_data')) {
            $form->setValues(Mage::registry('label_data')->getData());
        }
        
        return parent::_prepareForm();
    }
}

