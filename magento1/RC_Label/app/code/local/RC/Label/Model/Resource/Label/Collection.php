<?php

/**
 * Description of Collection
 * 
 * Module: Module_Name
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Resource_Label_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected $_indexTable;
    
    protected function _construct()
    {
        $this->_init('rc_label/label');
        $this->_indexTable = $this->getTable('rc_label/index');
    }
    
    /**
     * Filter by product(s)
     * @param array $productIds
     * @return \RC_Label_Model_Resource_Label_Collection
     */
    public function addProductFilter($productIds)
    {

        $this->getSelect()
            ->joinLeft(array('index_table' => $this->_indexTable),
                'main_table.label_id = index_table.label_id',
                array('category_page_text','product_page_text','initiation_date','expiration_date')
            );
        
        $this->addFieldToFilter('product_id',array('in' => $productIds));
        return $this;
    }
    
    /**
     * Add store filter
     * @param array $stores
     * @return \RC_Label_Model_Resource_Label_Collection
     */
    public function addStoreFilter($stores = null)
    {
        if (empty($stores)) {
            $stores = Mage::app()->getStore()->getId();
        }
        
        $this->addFieldToFilter('stores', array('like' => "%,$stores,%"));
        return $this;
    }
    
    /**
     * Filter by customer groups
     * @param array $customerGroups
     * @return \RC_Label_Model_Resource_Label_Collection
     */
    public function addCustomerGroupFilter($customerGroups = null)
    {
        if (empty($customerGroups)) {
            $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }
        
        $this->addFieldToFilter('customer_groups', array('like' => "%,$customerGroupId,%"));
        return $this;
    }
    
    /**
     * Sort by priority
     * @param strong $order
     * @return \RC_Label_Model_Resource_Label_Collection
     */
    public function setPriority($order = 'desc')
    {
        $this->setOrder('priority', $order);
        return $this;
    }
}

