<?php

/**
 * Labels Observer Model
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Observer extends Mage_Catalog_Model_Observer
{
    /**
     * Seting the right templates
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function rewriteProductTemplates(Varien_Event_Observer $observer)
    {
        if (!Mage::getStoreConfig('rc_label/general/auto_render')) {
            return $this;
        }
        
        $controller = $observer->getAction();
        $actionName = $controller->getFullActionName();
        
        if ($actionName === 'catalog_category_view') {
            $block = $controller->getLayout()->getBlock('product_list');
            if (!empty($block)) {
                $block->setTemplate('rc/catalog/product/list.phtml');
            }
        } elseif ($actionName === 'catalogsearch_result_index') {
            $block = $controller->getLayout()->getBlock('search_result_list');
            if (!empty($block)) {
                $block->setTemplate('rc/catalog/product/list.phtml');
            }
        } elseif ($actionName === 'catalog_product_view') {
            $block = $controller->getLayout()->getBlock('product.info.media');
            if (!empty($block)) {
                $block->setTemplate('rc/catalog/product/view/media.phtml');
            }
        }
        
        return $this;
    }
}

