<?php

/**
 * Labels Index Resource Model
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Resource_Index extends Mage_Index_Model_Resource_Abstract
{
    protected function _construct()
    {
        $this->_init('rc_label/index', 'label_id');
        $this->useIdxTable(false);
    }
    
    /**
     * Reindex all
     * @throws Exception
     */
    public function rebuildIndex()
    {
        $productCollection = Mage::getResourceModel('catalog/product_collection')->load();
        $labelCollection = Mage::getResourceModel('rc_label/label_collection')->load();
        $data = array();

        foreach ($productCollection as $product) {
            foreach ($labelCollection as $label) {
                if ($label->indexValidation($product)) {
                    $indexInfo = array(
                        'label_id' => $label->getId(), 
                        'product_id' => $product->getId(),
                        'category_page_text' => $label->getReplacedText($product, RC_Label_Block_Label::RENDERING_TYPE_CATEGORY),
                        'product_page_text' => $label->getReplacedText($product, RC_Label_Block_Label::RENDERING_TYPE_PRODUCT)
                    );
                    $data[] = array_merge($indexInfo, $label->getAtiveDateRange($product));
                }
            }
            $product->clearInstance();
        }
        
        if (!empty($data)) {
            $this->clearTemporaryIndexTable();
            $this->_prepareIndex($data);
        }
        
        $adapter = $this->_getWriteAdapter();
        $adapter->beginTransaction();

        try {
            $adapter->delete($this->getMainTable());

            if (!empty($data)) {
                $this->useDisableKeys(false);
                $this->insertFromTable($this->getIdxTable(), $this->getMainTable());
                $this->useDisableKeys(true);
            }

            $adapter->commit();
        } catch (Exception $e) {
            $adapter->rollBack();
            throw $e;
        }
    }
    
    /**
     * Reindex single label
     * @param int $labelId
     * @throws Exception
     */
    public function refreshByLabel($labelId)
    {
        $collection = Mage::getResourceModel('catalog/product_collection')->load();
        $label = Mage::getModel('rc_label/label')->load($labelId);
        $data = array();
        
        foreach ($collection as $product) {
            if ($label->indexValidation($product)) {
                $indexInfo = array(
                    'label_id' => $labelId, 
                    'product_id' => $product->getId(),
                    'category_page_text' => $label->getReplacedText($product, RC_Label_Block_Label::RENDERING_TYPE_CATEGORY),
                    'product_page_text' => $label->getReplacedText($product, RC_Label_Block_Label::RENDERING_TYPE_PRODUCT)
                );
                $data[] = array_merge($indexInfo, $label->getAtiveDateRange($product));
            }
            $product->clearInstance();
        }
        
        if (!empty($data)) {
            $this->clearTemporaryIndexTable();
            $this->_prepareIndex($data);
        }
            
        $adapter = $this->_getWriteAdapter();
        $adapter->beginTransaction();

        try {
            $where = $adapter->quoteInto('label_id IN(?)', $labelId);
            $adapter->delete($this->getMainTable(), $where);

            if (!empty($data)) {
                $this->useDisableKeys(false);
                $this->insertFromTable($this->getIdxTable(), $this->getMainTable());
                $this->useDisableKeys(true);
            }

            $adapter->commit();
        } catch (Exception $e) {
            $adapter->rollBack();
            throw $e;
        }
    }
    
    /**
     * Drop indexes for some label
     * @param array $labelIds
     * @throws Exception
     */
    public function dropForLabel($labelIds)
    {
        $adapter = $this->_getWriteAdapter();
        $adapter->beginTransaction();

        try {
            $where = $adapter->quoteInto('label_id IN(?)', $labelIds);
            $adapter->delete($this->getMainTable(), $where);
            $adapter->commit();
        } catch (Exception $e) {
            $adapter->rollBack();
            throw $e;
        }
    }
    
    /**
     * Rebuilt index for a product
     * @param int $productId
     * @throws Exception
     */
    public function refreshByProduct($productId)
    {
        $collection = Mage::getResourceModel('rc_label/label_collection')->load();
        $product = Mage::getModel('catalog/product')->load($productId);
        $data = array();
        
        foreach ($collection as $label) {
            if ($label->indexValidation($product)) {
                $indexInfo = array(
                    'label_id' => $label->getId(), 
                    'product_id' => $productId,
                    'category_page_text' => $label->getReplacedText($product, RC_Label_Block_Label::RENDERING_TYPE_CATEGORY),
                    'product_page_text' => $label->getReplacedText($product, RC_Label_Block_Label::RENDERING_TYPE_PRODUCT)
                );
                $data[] = array_merge($indexInfo, $label->getAtiveDateRange($product));
            }
            $label->clearInstance();
        }
        
        if (!empty($data)) {
            $this->clearTemporaryIndexTable();
            $this->_prepareIndex($data);
        }
            
        $adapter = $this->_getWriteAdapter();
        $adapter->beginTransaction();

        try {
            $where = $adapter->quoteInto('product_id IN(?)', $productId);
            $adapter->delete($this->getMainTable(), $where);

            if (!empty($data)) {
                $this->useDisableKeys(false);
                $this->insertFromTable($this->getIdxTable(), $this->getMainTable());
                $this->useDisableKeys(true);
            }

            $adapter->commit();
        } catch (Exception $e) {
            $adapter->rollBack();
            throw $e;
        }
    }
    
    /**
     * Drop th indexes for some products
     * @param array $productIds
     * @throws Exception
     */
    public function dropForProduct($productIds)
    {
        $adapter = $this->_getWriteAdapter();
        $adapter->beginTransaction();

        try {
            $where = $adapter->quoteInto('product_id IN(?)', $productIds);
            $adapter->delete($this->getMainTable(), $where);
            $adapter->commit();
        } catch (Exception $e) {
            $adapter->rollBack();
            throw $e;
        }
    }
    
    /**
     * Execute query
     * @param array $data
     */
    protected function _prepareIndex($data)
    {
        if (!empty($data))
        {
            $write      = $this->_getWriteAdapter();
            $idxTable   = $this->getIdxTable();
            
            $sql = 'INSERT INTO '.$idxTable.'(label_id, product_id, category_page_text, product_page_text, initiation_date, expiration_date) VALUES ';
            $sqlParts = array();
            
            foreach ($data as $row) {
                $sqlParts[] = '('.$row['label_id'].', '
                    .$row['product_id'].', "'
                    .$row['category_page_text'].'", "'
                    .$row['product_page_text'].'", "'
                    .$row['initiation_date'].'", "'
                    .$row['expiration_date'].'")';
            }
            
            if (!empty($sqlParts)) {
                $sql .= implode(',', $sqlParts);
                unset($sqlParts);            
                $write->query($sql);
            }
        }
    }
}

