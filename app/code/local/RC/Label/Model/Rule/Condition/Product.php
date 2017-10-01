<?php

/**
 * Labels Product Rule Conditions
 * 
 * Module: Module_Name
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Rule_Condition_Product extends Mage_Rule_Model_Condition_Product_Abstract
{
    /**
     * Loading options for product rules
     * 
     * @param bool $loadSpecialAttributes
     * @return \RC_Label_Model_Rule_Condition_Product
     */
    public function loadAttributeOptions($loadSpecialAttributes = true)
    {
        $productAttributes = Mage::getResourceSingleton('catalog/product')
            ->loadAllAttributes()
            ->getAttributesByCode();

        $attributes = array();
        foreach ($productAttributes as $attribute) {
            /* @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
            if (!$attribute->isAllowedForRuleCondition()) {
                continue;
            }
            $attributes[$attribute->getAttributeCode()] = $attribute->getFrontendLabel();
        }
        
        if ($loadSpecialAttributes) {
            $this->_addSpecialAttributes($attributes);
        }
        
        asort($attributes);
        $this->setAttributeOption($attributes);

        return $this;
    }
    
    /**
     * Adding extra attributes
     * @param array $attributes
     */
    protected function _addSpecialAttributes(&$attributes)
    {
        parent::_addSpecialAttributes($attributes);
        
        $helper = Mage::helper('rc_label');
        $attributes['id'] = $helper->__('ID');
        $attributes['product_type'] = $helper->__('Product Type');
        $attributes['quantity'] = $helper->__('Stock Quantity');
    }
    
    /**
     * Adding and sorting special attributes
     * @return array
     */
    public function loadSpecialAttributes()
    {
        $attributes = array();
        $this->_addSpecialAttributes($attributes);

        asort($attributes);
        return $attributes;
    }
    
    /**
     * Validate attreibutes
     * 
     * @param Varien_Object $object
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        $parentValidation = parent::validate($object);
        
        if (!$parentValidation) {
            $attrCode = $this->getAttribute();
            if ('id' == $attrCode) {
                return $this->validateAttribute($object->getId());
            } 
            if ('product_type' == $attrCode) {
                return $this->validateAttribute($object->getTypeID());
            }
            if ('quantity' == $attrCode) {
                return $this->validateAttribute((int)$object->getStockItem()->getQty());
            }
        }
        
        return $parentValidation;
    }
    
    /**
     * Prepare value options
     */
    protected function _prepareValueOptions()
    {
        parent::_prepareValueOptions();
        
        if ($this->getAttribute() === 'product_type') {
            $selectOptions = Mage::getModel('catalog/product_type')->getOptionArray();
            $this->setData('value_select_options', $selectOptions);
        }
    }
    
    /**
     * Set the product input type attribute to select
     * @return string
     */
    public function getInputType()
    {
        if ($this->getAttribute()==='product_type') {
            return 'select';
        }
        
        return parent::getInputType();
    }
    
    /**
     * Set the product value type attribute to select 
     * @return string
     */
    public function getValueElementType()
    {
        if ($this->getAttribute()==='product_type') {
            return 'select';
        }
        
        return parent::getValueElementType();
    }
}

