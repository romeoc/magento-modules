<?php

namespace RC\Offices\Model\ResourceModel\Office;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'office_id';
    protected $_eventPrefix = 'rc_office_collection';
    protected $_eventObject = 'office_collection';

    /**
     * Define collection
     * @return void
     */
    protected function _construct()
    {
        $this->_init('RC\Offices\Model\Office', 'RC\Offices\Model\ResourceModel\Office');
    }
}

