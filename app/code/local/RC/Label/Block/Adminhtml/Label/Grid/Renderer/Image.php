<?php

/**
 * Labels Grid Image Renderer
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    /**
     * Image renderer (for the grid)
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $file = Mage::helper('rc_label')->__('No Image');
        
        if (!empty($value)) {
            $path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
            $file = '<img src="' . $path . $value . '" width="25" height="25" />';
        }
        
        return $file;
    }
}

