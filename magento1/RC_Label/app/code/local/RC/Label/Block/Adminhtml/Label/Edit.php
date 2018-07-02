<?php

/**
 * Labels Admin Form Container
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label_Edit extends Mage_Adminhtml_Block_Widget_Form_Container 
{
    /**
     * Constructor for the edit form container
     */
    public function __construct() 
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'rc_label';
        $this->_controller = 'adminhtml_label';

        $this->_updateButton('save', 'label', Mage::helper('rc_label')->__('Save Label'));
        $this->_updateButton('delete', 'label', Mage::helper('rc_label')->__('Delete Label'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    
    /**
     * Get header text
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('label_data') && Mage::registry('label_data')->getId()) {
            return Mage::helper('rc_label')->__("Edit Label '%s'", $this->htmlEscape(Mage::registry('label_data')->getName()));
        } else {
            return Mage::helper('rc_label')->__('Add Label');
        }
    }
}

