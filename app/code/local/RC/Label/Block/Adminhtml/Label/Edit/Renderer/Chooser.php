<?php

/**
 * Labels image chooser
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label_Edit_Renderer_Chooser extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
    /**
     * Render the image picker
     * 
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $value = $element->getValue();
        $helper = Mage::helper('rc_label');
        
        $imageHtml = '';
        $deleteButtonHtml = '';
        $buttonLabel = $helper->__('Insert Image');
        
        $containerStyle = 'padding-top: 15px;';
        $insertButtonStyle = '';
        
        if (!empty($value)) {
            
            $buttonLabel = $helper->__('Change Image');
            
            $containerStyle = 'padding-top: 20px;';
            $insertButtonStyle = 'margin: 0 9px';
            
            $path = Mage::getBaseUrl('media');
            $url = $path . $value;
            $elementId = $element->getId();
            
            $imageHtml = "<div style='float: left;'><img src='$url' alt='$elementId' height='40px' style='padding-top: 10px;'/></div>";
            
            $deleteButtonHtml = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setType('button')
                ->setClass('delete')
                ->setLabel($this->__('Remove Image'))
                ->setOnclick("document.getElementById('$elementId').value=''")
                ->toHtml();
        }
        
        $chooserUrl = $this->getUrl('*/cms_wysiwyg_images_chooser/index', array('target_element_id' => $element->getId()));
        $insertButtonHtml = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setLabel($buttonLabel)
            ->setOnclick("MediabrowserUtility.openDialog('$chooserUrl');")
            ->setStyle($insertButtonStyle)
            ->toHtml();
        
        $html = "<div style='height: 40px;'> $imageHtml <div style='$containerStyle'> $insertButtonHtml $deleteButtonHtml </div></div>";
        $element->setData('after_element_html' , $html);
        
        $this->_element = $element;
        return $this->toHtml();
    }
}

