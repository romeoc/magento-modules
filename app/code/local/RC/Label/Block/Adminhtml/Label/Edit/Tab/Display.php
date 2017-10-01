<?php

/**
 * Labels Admin Form Display Tab
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label_Edit_Tab_Display extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare the displays tab form
     */
    protected function _prepareForm() 
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $helper = Mage::helper('rc_label');
        
        $productFieldset = $form->addFieldset('label_display_product', array('legend' => $helper->__('Product Page Display Settings')));
        $categoryFieldset = $form->addFieldset('label_display_category', array('legend' => $helper->__('Category Page Display Settings')));
        
        $productFieldset->addField('display_on_product', 'select', array(
            'label' => $helper->__('Display On Product Page'),
            'name' => 'display_on_product',
            'class' => 'required-entry',
            'required' => true,
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));
        
        $productImageElement = $productFieldset->addField('product_image', 'text', array(
            'label' => $helper->__('Product Page Image'),
            'required' => false,
            'name' => 'product_image',
            'readonly' => true
        ));

        $productImageElement->setRenderer($this->getLayout()->createBlock('rc_label/adminhtml_label_edit_renderer_chooser'));
        
        $productFieldset->addField('product_image_width', 'text', array(
            'label' => $helper->__('Image Width'),
            'name' => 'product_image_width',
        ));
        
        $productFieldset->addField('product_image_height', 'text', array(
            'label' => $helper->__('Image Height'),
            'name' => 'product_image_height',
        ));
        
        $productFieldset->addField('product_position', 'select', array(
            'label'     => $helper->__('Image Position'),
            'name'      => 'product_position',
            'values'    => Mage::getSingleton('rc_label/config_source_position')->toOptionArray(),
        )); 
        
        $productFieldset->addField('product_image_text', 'text', array(
            'label' => $helper->__('Image Text'),
            'name' => 'product_image_text',
        ));
        
        $productInsertButton = $this->getLayout()
            ->createBlock('adminhtml/widget_button', '', array(
                'type' => 'button',
                'label' => Mage::helper('adminhtml')->__('Insert Variable...'),
                'onclick' => "openVariableChoose('product_image_text');return false;"
            ));
        
        $productFieldset->addField('product_insert_variable', 'note', array(
            'text' => $productInsertButton->toHtml()
        ));
        
        
        $productFieldset->addField('product_image_text_styles', 'text', array(
            'label' => $helper->__('Image Text Styles'),
            'name' => 'product_image_text_styles',
        ));
        
        $categoryFieldset->addField('display_on_category', 'select', array(
            'label' => $helper->__('Display On Category Page'),
            'name' => 'display_on_category',
            'class' => 'required-entry',
            'required' => true,
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));
        
        $categoryImageElement = $categoryFieldset->addField('category_image', 'text', array(
            'label' => $helper->__('Category Page Image'),
            'required' => false,
            'name' => 'category_image',
            'readonly' => true
        ));

        $categoryImageElement->setRenderer($this->getLayout()->createBlock('rc_label/adminhtml_label_edit_renderer_chooser'));
        
        
        $categoryFieldset->addField('category_image_width', 'text', array(
            'label' => $helper->__('Image Width'),
            'name' => 'category_image_width',
        ));
        
        $categoryFieldset->addField('category_image_height', 'text', array(
            'label' => $helper->__('Image Height'),
            'name' => 'category_image_height',
        ));
        
        $categoryFieldset->addField('category_position', 'select', array(
            'label'     => $helper->__('Image Position'),
            'name'      => 'category_position',
            'values'    => Mage::getSingleton('rc_label/config_source_position')->toOptionArray(),
        )); 
        
        $categoryFieldset->addField('category_image_text', 'text', array(
            'label' => $helper->__('Image Text'),
            'name' => 'category_image_text',
        ));
        
        $categoryInsertButton = $this->getLayout()
            ->createBlock('adminhtml/widget_button', '', array(
                'type' => 'button',
                'label' => Mage::helper('adminhtml')->__('Insert Variable...'),
                'onclick' => "openVariableChoose('category_image_text');return false;"
            ));
        
        $categoryFieldset->addField('category_insert_variable', 'note', array(
            'text' => $categoryInsertButton->toHtml()
        ));
                
        $categoryFieldset->addField('category_image_text_styles', 'text', array(
            'label' => $helper->__('Image Text Styles'),
            'name' => 'category_image_text_styles',
        ));
        
        $categoryFieldset->addField('variables', 'hidden', array(
            'name' => 'variables',
        ))->setAfterElementHtml('<script>
            function openVariableChoose ( element ) {
                Variables.init(element);
                var variables = $("variables").value.evalJSON();
                
                if (variables) {
                    Variables.openVariableChooser(variables);
                }
            }
        </script>');
        
        if (Mage::registry('label_data')) {
            $labelData = Mage::registry('label_data')->getData();
            $variables = array(Mage::getModel('rc_label/config_source_variables')->toOptionArray(true));
            $labelData['variables'] =  Zend_Json::encode($variables);
            
            $form->setValues($labelData);
        }
    }
}

