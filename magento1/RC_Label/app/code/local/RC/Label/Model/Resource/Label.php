<?php

/**
 * Label Resource Model
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Resource_Label extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct() {
        $this->_init('rc_label/label', 'label_id');
    }
}

