<?php

/**
 * Labels Rule Conditions
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Rule_Condition_Combine extends Mage_Rule_Model_Condition_Combine
{
    /**
     * Basic constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType('rc_label/rule_condition_combine');
    }
    
    /**
     * Get rule options for new condition
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $productCondition = Mage::getModel('rc_label/rule_condition_product');
        $productAttributes = $productCondition->loadAttributeOptions(false)->getAttributeOption();
        $helper = Mage::helper('rc_label');
        
        $attributes = array();
        foreach ($productAttributes as $code=>$label) {
            $attributes[] = array('value'=>'rc_label/rule_condition_product|'.$code, 'label'=>$label);
        }
        
        $specialAttributesList = $productCondition->loadSpecialAttributes();
        $specialAttributes = array();
        foreach ($specialAttributesList as $code=>$label) {
            $specialAttributes[] = array('value'=>'rc_label/rule_condition_product|'.$code, 'label'=>$label);
        }
        
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive($conditions, array(
            array('value'=>'rc_label/rule_condition_combine', 'label'=>Mage::helper('catalogrule')->__('Conditions Combination')),
            array('label'=>$helper->__('Special Attributes'), 'value'=>$specialAttributes),
            array('label'=>$helper->__('Product Attributes'), 'value'=>$attributes),
        ));
        return $conditions;
    }
}

