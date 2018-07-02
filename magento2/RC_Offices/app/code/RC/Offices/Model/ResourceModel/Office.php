<?php

namespace RC\Offices\Model\ResourceModel;

class Office extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('rc_offices', 'office_id');
    }
}

