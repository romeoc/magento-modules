<?php

/**
 * Labels Admin Form Tabs
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->setId('label_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('rc_label')->__('Labels'));
    }

    /**
     * Adding the tabs
     * @return string
     */
    protected function _beforeToHtml() 
    {
        $this->addTab('general', array(
            'label' => Mage::helper('rc_label')->__('General'),
            'title' => Mage::helper('rc_label')->__('General'),
            'content' => $this->getLayout()->createBlock('rc_label/adminhtml_label_edit_tab_general')->toHtml(),
        ));

        $this->addTab('conditions', array(
            'label' => Mage::helper('rc_label')->__('Conditions'),
            'title' => Mage::helper('rc_label')->__('Conditions'),
            'content' => $this->getLayout()->createBlock('rc_label/adminhtml_label_edit_tab_conditions')->toHtml(),
        ));
        
        $this->addTab('display', array(
            'label' => Mage::helper('rc_label')->__('Display'),
            'title' => Mage::helper('rc_label')->__('Display'),
            'content' => $this->getLayout()->createBlock('rc_label/adminhtml_label_edit_tab_display')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}

