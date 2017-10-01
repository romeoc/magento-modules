<?php

/**
 * Labels Block
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Label extends Mage_Core_Block_Template
{
    const RENDERING_TYPE_PRODUCT = 'product';
    const RENDERING_TYPE_CATEGORY = 'category';
    const RENDERING_TYPE_CURRENT = 'current';
    
    /**
     * Main label block constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->setTemplate('rc/label.phtml');
    }
    
    /**
     * Checking id we are on a product page or listing page.
     * @return \RC_Label_Block_Label
     */
    public function _beforeToHtml()
    {
        parent::_beforeToHtml();
        
        $this->loadLabels();
        
        if ($this->getRendering() === self::RENDERING_TYPE_CURRENT) {
            $rendering = (Mage::registry('current_product')) ? self::RENDERING_TYPE_PRODUCT : self::RENDERING_TYPE_CATEGORY;
            $this->setRendering($rendering);
        }
        
        return $this;
    }
    
    /**
     * Loading the labels
     */
    protected function loadLabels()
    {
        $collection = Mage::getResourceModel('rc_label/label_collection')
            ->addProductFilter($this->getProductId())
            ->addStoreFilter()
            ->addCustomerGroupFilter()
            ->setPriority();
        
        if (!Mage::getStoreConfig('rc_label/general/render_multiple')) {
            $collection->setPageSize(1);
        }
        
        $this->setLabels($collection);
    }
    
    /**
     * Generating label data
     * @param RC_Label_Model_Label $label
     * @return string
     */
    public function getLabelData($label) 
    {
        $rendering = $this->getRendering();
        $helper = Mage::helper('rc_label');
        $data = array();
        
        if ($rendering === self::RENDERING_TYPE_PRODUCT) {
            $width = $label->getProductImageWidth();
            if (empty($width)) {
                $width = Mage::getStoreConfig('rc_label/general/default_product_page_width');
            }
            
            $height = $label->getProductImageHeight();
            if (empty($height)) {
                $height = Mage::getStoreConfig('rc_label/general/default_product_page_height');
            }
            
            $data['is_active'] = $label->getDisplayOnProduct();
            $data['position'] = $label->getProductPosition();
            $data['image'] = $helper->getResizedImage($label->getProductImage(), $width, $height);
            $data['width'] = $width;
            $data['height'] = $height;
            $data['text'] = $label->getProductPageText();
            $data['styles'] = $label->getProductImageTextStyles();
        } elseif ($rendering === self::RENDERING_TYPE_CATEGORY) {
            $width = $label->getCategoryImageWidth();
            if (empty($width)) {
                $width = Mage::getStoreConfig('rc_label/general/default_category_page_width');
            }
            
            $height = $label->getCategoryImageHeight();
            if (empty($height)) {
                $height = Mage::getStoreConfig('rc_label/general/default_category_page_height');
            }
            
            $data['is_active'] = $label->getDisplayOnCategory();
            $data['position'] = $label->getCategoryPosition();
            $data['image'] = $helper->getResizedImage($label->getCategoryImage(), $width, $height);
            $data['width'] = $width;
            $data['height'] = $height;
            $data['text'] = $label->getCategoryPageText();
            $data['styles'] = $label->getCategoryImageTextStyles();
        }
        
        $positions = Mage::getSingleton('rc_label/config_source_position')->toOptionArray();
        $positionClass = $positions[$data['position']-1]['label'];
        $positionClass = str_replace(' ', '-', strtolower($positionClass));
        
        $positionExtra = '';
        if (strpos($positionClass,'middle') !== false) {
            $heightAdjustment = $data['height'] / 2;
            $positionExtra .= 'margin-top: -' . $heightAdjustment . 'px; ';
        }
        if (strpos($positionClass,'center') !== false) {
            $widthtAdjustment = $data['width'] / 2;
            $positionExtra .= 'margin-left: -' . $widthtAdjustment . 'px; ';
        }

        $data['position'] = $positionClass;
        $data['position_extra'] = $positionExtra;
        
        return $data;
    }
}

