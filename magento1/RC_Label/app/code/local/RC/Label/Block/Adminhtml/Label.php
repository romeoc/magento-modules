<?php

/**
 * Label Grid Container
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Constructor with basic seupt
     */
    public function __construct() 
    {
        $this->_blockGroup = 'rc_label';
        $this->_controller = 'adminhtml_label';
        $this->_headerText = Mage::helper('rc_label')->__('Manage Labels');
        $this->_addButtonLabel = Mage::helper('rc_label')->__('Add Label');
        parent::__construct();
    }
}

