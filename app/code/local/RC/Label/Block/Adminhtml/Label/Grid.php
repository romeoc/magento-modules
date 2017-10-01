<?php

/**
 * Labels Admin Grid
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Block_Adminhtml_Label_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Constructor. Basic setup for the grid.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('labelGrid');
        $this->setDefaultSort('label_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    
    /**
     * Prepare the collection used for the grid
     * @return RC_Label_Model_Resource_Label_Collection
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('rc_label/label')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    /**
     * Where to redirect when a row is clicked
     * @return string(url)
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    /**
     * Grid columns
     * @return $this
     */
    protected function _prepareColumns()
    {
        $helper = Mage::helper('rc_label');
        
        $this->addColumn(
            'label_id', array(
                'header' => $helper->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'label_id',
            )
        );
        
        $this->addColumn('name', array(
            'header'    => $helper->__('Name'),
            'index'     => 'name',
        ));
        
        $this->addColumn('date_from', array(
            'header'    => $helper->__('From Date'),
            'index'     => 'date_from',
            'type'      => 'datetime'
        ));
        
        $this->addColumn('date_to', array(
            'header'    => $helper->__('To Date'),
            'index'     => 'date_to',
            'type'      => 'datetime'
        ));
        
        $this->addColumn('product_image', array(
            'header'    => $helper->__('Product Image'),
            'index'     => 'product_image',
            'align'     => 'center',
            'renderer'  => 'rc_label/adminhtml_label_grid_renderer_image'
        ));
        
        $this->addColumn('category_image', array(
            'header'    => $helper->__('Category Image'),
            'index'     => 'category_image',
            'align'     => 'center',
            'renderer'  => 'rc_label/adminhtml_label_grid_renderer_image'
        ));
        
        $this->addColumn('status', array(
            'header'    => $helper->__('Status'),
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => $helper->__('Active'),
                0 => $helper->__('Disabled')
            )
        ));
        
        $this->addExportType('*/*/exportCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportXml', $helper->__('XML'));

        return parent::_prepareColumns();
    }
    
    /**
     * Mass action settings
     * @return \RC_Label_Block_Adminhtml_Label_Grid
     */
    protected function _prepareMassaction()
    {
        $helper = Mage::helper('rc_label');
        
        $this->setMassactionIdField('label_id');
        $this->getMassactionBlock()->setFormFieldName('labels');
        
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $helper->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => $helper->__('Are you sure?')
        ));
        
        return $this; 
    }
}

