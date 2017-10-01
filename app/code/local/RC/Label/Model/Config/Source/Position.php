<?php

/**
 * Labels Position Source Config
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Config_Source_Position 
{
    /**
     * How to position the label
     * @return array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('rc_label');
        $positions = array(
            array('value' => '1', 'label' => $helper->__('Top Left')),
            array('value' => '2', 'label' => $helper->__('Top Center')),
            array('value' => '3', 'label' => $helper->__('Top Right')),
            
            array('value' => '4', 'label' => $helper->__('Middle Left')),
            array('value' => '5', 'label' => $helper->__('Middle Center')),
            array('value' => '6', 'label' => $helper->__('Middle Right')),
            
            array('value' => '7', 'label' => $helper->__('Bottom Left')),
            array('value' => '8', 'label' => $helper->__('Bottom Center')),
            array('value' => '9', 'label' => $helper->__('Bottom Right')),
        );

        return $positions;
    }
}

