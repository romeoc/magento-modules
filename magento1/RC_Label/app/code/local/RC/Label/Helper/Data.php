<?php

/**
 * Labels Helper
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Create a label block and render it
     * @param int$productId
     * @param int $rendering
     * @return string
     */
    public function createLabel($productId, $rendering = RC_Label_Block_Label::RENDERING_TYPE_CURRENT)
    {
        return Mage::app()->getLayout()
            ->createBlock('rc_label/label')
            ->setProductId($productId)
            ->setRendering($rendering)
            ->toHtml();
    }
    
    /**
     * Resize the original image
     * @param string $imageName
     * @param float $xSize
     * @param float $ySize
     * @return string
     * @throws Exception
     */
    public function getResizedImage($imageName, $xSize = null, $ySize = null) 
    {
        return Mage::getBaseUrl('media') . $imageName;
        
        if (!$xSize && !$ySize) {
            return $imageName;
        }
        
        $resizeFolder = (string) $xSize . "x" . (string) $ySize;
        $imagePath = Mage::getBaseDir('media') . DS . 'label' . DS . $resizeFolder;
        
         if (!file_exists($imagePath)) {
            if (false === mkdir($imagePath, 0777)) {
                throw new Exception($this->__('Could not create resized images folder'));
            }
        }

        $resizedImageChunks = str_replace('wysiwyg/', '' , $imageName);
        $resizedImageName = end($resizedImageChunks);
        
        $resizedImagePath = $imagePath . DS . $resizedImageName;
        $realImagePath = Mage::getBaseDir('media') . DS . $imageName;

        if (!file_exists($resizedImagePath) && file_exists($realImagePath)) {
            $imageObj = new Varien_Image($realImagePath);
            $imageObj->constrainOnly(false);
            $imageObj->keepAspectRatio(true);
            $imageObj->keepTransparency(true);
            $imageObj->keepFrame(false);
            $imageObj->resize($xSize, $ySize);
            $imageObj->save($resizedImagePath);
        }

        return Mage::getBaseUrl('media') . 'label/' . $resizeFolder . '/' . $resizedImageName;
    }
}

