<?php

/**
 * Rounding Methods SOurce Model
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Config_Source_Rounding
{
    /**
     * Rounding options for the prices
     * @return array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('rc_label');
        $positions = array(
            array('value' => 'floor', 'label' => $helper->__('Round down')),
            array('value' => 'round', 'label' => $helper->__('Round to nearest')),
            array('value' => 'ceil', 'label' => $helper->__('Round up')),
        );

        return $positions;
    }
}

