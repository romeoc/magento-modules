<?php

/**
 * Label Model
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Label extends Mage_Rule_Model_Abstract
{
    const ENTITY = 'rc_label';
    
    public function _construct() 
    {
        $this->_init('rc_label/label');
    }

    public function getActionsInstance()
    {
        return Mage::getModel('rule/action_collection');
    }

    public function getConditionsInstance()
    {
        return Mage::getModel('rc_label/rule_condition_combine');
    }
    
    /**
     * Preparing data before it is saved
     * @param array $data
     * @return \RC_Label_Model_Label
     */
    public function prepareDataForSave($data)
    {
        $data['conditions'] = $data['rule']['conditions'];
        
        $data['stores'] = ',' . implode(',', $data['stores']) . ',';  
        $data['customer_groups'] = ',' . implode(',', $data['customer_groups']) . ',';  
        
        $this->loadPost($data);
        return $this;
    }
    
    /**
     * Validate data
     * @return boolean
     */
    public function frontendValidation()
    {
        $now = Mage::getModel('core/date')->date('Y-m-d H:m:s');
        
        if (!$this->getStatus()) {
            return false;
        }
        
        $expirationDate = $this->getExpirationDate();
        if ($now < $this->getInitiationDate() 
                || ( $expirationDate != '0000-00-00 00:00:00'  && $now > $this->getExpirationDate())) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Validate index
     * @param Mage_Catalog_Model_Product $product
     * @return boolean
     */
    public function indexValidation($product) 
    {
        if (!$this->getConditions()->validate($product)) {
            return false;
        }
        
        if ($this->getIsOnSsale()) {
            $price = $product->getPrice();
            $discountAmount = $price - $product->getFinalPrice();
            $discountPercent = ($price / $discountAmount) * 100;
            
            if ($discountPercent < $this->getMinimumDiscount() || $discountPercent > $this->getMaximumDiscount()) {
                return false;
            }
        }
        
        return true;                                                                          
    }
    
    /**
     * Checking when the product has an active label attached
     * @param Mage_Catalog_Model_Product $product
     * @return array
     */
    public function getAtiveDateRange($product)
    {
        $startingDate = $this->getDateFrom();
        $endingDate = $this->getDateTo();
        
        if ($this->getIsNew()) {
            if ($this->getIsNewDefault()) {
                $productNewFrom = $product->getNewsFromDate();
                $productNewUntil = $product->getNewsToDate();
                if (!empty($productNewFrom) 
                        && ($productNewFrom > $startingDate || empty($startingDate))) {
                    $startingDate = $productNewFrom;
                }
                if (!empty($productNewUntil) 
                        && ($productNewUntil < $endingDate || empty($endingDate))) {
                    $endingDate = $productNewUntil;
                }
            } else {
                $createdAt = $product->getCreatedAt();
                $isNewStartingDate = $this->getIsNewStartingDate();
                $isNewEndingDate = $this->getIsNewEndingDate();
                if (!empty($isNewStartingDate) 
                        && $createdAt > $isNewStartingDate 
                        && ( $startingDate < $isNewStartingDate || empty($startingDate))) {
                    $startingDate = $isNewStartingDate;
                }
                if (!empty($isNewEndingDate) 
                        && $createdAt < $isNewEndingDate 
                        && ( $endingDate > $isNewEndingDate || empty($endingDate))) {
                    $endingDate = $isNewEndingDate;
                }
            }
        }
        
        return array(
            'initiation_date' => $startingDate,
            'expiration_date' => $endingDate
        );
    }
    
    /**
     * Replace variables for label text
     * 
     * @param Mage_Catalog_Model_Product $product
     * @param int $rendering
     * @return string
     */
    public function getReplacedText($product, $rendering)
    {
        $originalText = '';
        
        switch ($rendering){
            case (RC_Label_Block_Label::RENDERING_TYPE_PRODUCT):
                $originalText = $this->getProductImageText();
                break;
            case (RC_Label_Block_Label::RENDERING_TYPE_CATEGORY):
                $originalText = $this->getCategoryImageText();
                break;
        }
        
        if (!empty($originalText)) {
            $variables = '';
            preg_match_all('/({{\w+\}})/', $originalText, $variables);
            $roundingMethod = Mage::getStoreConfig('rc_label/general/round_method');

            foreach ($variables[0] as $variable) {
                $newValue = '';
                switch ($variable) {
                    case ('{{price}}'):
                        $newValue = $product->getPrice();
                        break;
                    case ('{{special_price}}'):
                        $newValue = $product->getFinalPrice();
                        break;
                    case ('{{discount_ammount}}'):
                        $newValue = $product->getPrice() - $product->getFinalPrice();
                        break;
                    case ('{{discount_percent}}'):
                        $price = $product->getPrice();
                        $discountAmount = $price - $product->getFinalPrice();
                        $newValue = $roundingMethod(($price / $discountAmount) * 100);
                        break;
                    case ('{{sku}}'):
                        $newValue = $product->getSku();
                        break;
                    case ('{{qty}}'):
                        $newValue = $product->getStockItem()->getQty();
                        break;
                    case ('{{br}}'):
                        $newValue = '<br />';
                        break;
                    case ('{{lifetime_in_days}}'):
                        $createdAt = $product->getCreatedAt();
                        $now = Date('Y-m-d');
                        $diff = abs(strtotime($now) - strtotime($createdAt));
                        $newValue = floor($diff / 86400);
                        break;
                    case ('{{lifetime_in_hours}}'):
                        $createdAt = $product->getCreatedAt();
                        $now = Date('Y-m-d');
                        $diff = abs(strtotime($now) - strtotime($createdAt));
                        $newValue = floor($diff / 3600);
                        break;
                    default:
                        $attributeCode = substr($variable, 2, -2);
                        $newValue = $this->getData($attributeCode);
                        break;
                }
                
                $originalText = str_replace($variable, $newValue, $originalText);
            }
        }
        
        return $originalText;
    }
}

