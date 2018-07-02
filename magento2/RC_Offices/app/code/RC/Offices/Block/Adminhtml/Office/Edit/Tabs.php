<?php

namespace RC\Offices\Block\Adminhtml\Office\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * constructor
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('office_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Office Information'));
    }
}

