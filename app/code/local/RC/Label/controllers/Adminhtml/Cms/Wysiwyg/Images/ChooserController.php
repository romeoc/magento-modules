<?php

/**
 * Wysiwyg Image Chooser Controller
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */

require_once  'Mage/Adminhtml/controllers/Cms/Wysiwyg/ImagesController.php';
class RC_Label_Adminhtml_Cms_Wysiwyg_Images_ChooserController extends Mage_Adminhtml_Cms_Wysiwyg_ImagesController
{
    public function onInsertAction()
    {
        $helper = Mage::helper('cms/wysiwyg_images');
        $storeId = $this->getRequest()->getParam('store');

        $filename = $this->getRequest()->getParam('filename');
        $filename = $helper->idDecode($filename);

        Mage::helper('catalog')->setStoreId($storeId);
        $helper->setStoreId($storeId);

        $fileUrl = $helper->getCurrentUrl() . $filename;
        $mediaPath = str_replace(Mage::getBaseUrl('media'),'',$fileUrl);

        $this->getResponse()->setBody($mediaPath);
    }
}
