<?php

/**
 * Labels Variable Source 
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Config_Source_Variables
{
    protected $labelVariables = array();

    /**
     * These variables are automatically replaced when the label is loaded
     */
    public function __construct()
    {
        $this->labelVariables = array(
            array(
                'value' => 'price',
                'label' => Mage::helper('rc_label')->__('Regular Price')
            ),
            array(
                'value' => 'special_price',
                'label' => Mage::helper('rc_label')->__('Special Price')
            ),
            array(
                'value' => 'discount_ammount',
                'label' => Mage::helper('rc_label')->__('Discount Amount')
            ),
            array(
                'value' => 'discount_percent',
                'label' => Mage::helper('rc_label')->__('Discount Percent')
            ),
            array(
                'value' => 'sku',
                'label' => Mage::helper('rc_label')->__('Sku')
            ),
            array(
                'value' => 'qty',
                'label' => Mage::helper('rc_label')->__('Quantity In Stock')
            ),
            array(
                'value' => 'br',
                'label' => Mage::helper('rc_label')->__('New Line')
            ),
            array(
                'value' => 'lifetime_in_days',
                'label' => Mage::helper('rc_label')->__('Lifetime (in days)')
            ),
            array(
                'value' => 'lifetime_in_hours',
                'label' => Mage::helper('rc_label')->__('Lifetime (in hours)')
            ),
            array(
                'value' => 'attribute_code',
                'label' => Mage::helper('rc_label')->__('Custom Attribute (Note that "attribute_code" should be replaced as desired)')
            )
        );
    }

    /**
     * Adding brakets
     * @param bool $withGroup
     * @return array
     */
    public function toOptionArray($withGroup = false)
    {
        $optionArray = array();
        foreach ($this->labelVariables as $variable) {
            $optionArray[] = array(
                'value' => '{{' . $variable['value']. '}}',
                'label' => $variable['label']
            );
        }
        if ($withGroup && $optionArray) {
            $optionArray = array(
                'label' => Mage::helper('rc_label')->__('Labels Text Variables'),
                'value' => $optionArray
            );
        }
        return $optionArray;
    }
}

