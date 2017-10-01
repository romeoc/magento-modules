<?php
/**
 * Labels Install Script
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('rc_label/label'))
    ->addColumn('label_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true
    ), 'ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable' => false,
    ), 'Label Name')
    ->addColumn('status',Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nullable' => false,
        'default' => 0
    ), 'Label Status')
    ->addColumn('priority', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => true,
    ), 'Label Priority')
    ->addColumn('stores', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nulable' => true,
    ), 'Label Stores')
    ->addColumn('customer_groups', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nulable' => true,
    ), 'Customer Groups')
    ->addColumn('date_range_status',Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nullable' => false,
        'default' => 0
    ), 'Date Range Status')
    ->addColumn('date_from', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true
    ), 'Date From')
    ->addColumn('date_to', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true
    ), 'Date To')
    ->addColumn('display_on_category', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nulable' => false,
        'default' => 0,
    ), 'Display on Category Page')
    ->addColumn('display_on_product', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nulable' => false,
        'default' => 0,
    ), 'Display on Product Page')
    ->addColumn('product_position', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nulable' => false,
        'default' => 1,
    ), 'Product Page Position')
    ->addColumn('category_position', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nulable' => false,
        'default' => 1,
    ), 'Category Page Position')
    ->addColumn('category_image', Varien_Db_Ddl_Table::TYPE_TEXT, 256, array(
        'nulable' => true,
    ), 'Category Page Image')
    ->addColumn('product_image', Varien_Db_Ddl_Table::TYPE_TEXT, 256, array(
        'nulable' => true,
    ), 'Product Page Image')
    ->addColumn('product_image_width', Varien_Db_Ddl_Table::TYPE_SMALLINT, 4, array(
        'nullable' => true,
    ), 'Product Page Image Width')
    ->addColumn('product_image_height', Varien_Db_Ddl_Table::TYPE_SMALLINT, 4, array(
        'nullable' => true,
    ), 'Product Page Image Height')
    ->addColumn('category_image_width', Varien_Db_Ddl_Table::TYPE_SMALLINT, 4, array(
        'nullable' => true,
    ), 'Category Page Image Width')
    ->addColumn('category_image_height', Varien_Db_Ddl_Table::TYPE_SMALLINT, 4, array(
        'nullable' => true,
    ), 'Category Page Image Height')
    ->addColumn('product_image_text', Varien_Db_Ddl_Table::TYPE_TEXT, 256, array(
        'nulable' => true,
    ), 'Product Page Image Text')
    ->addColumn('category_image_text', Varien_Db_Ddl_Table::TYPE_TEXT, 256, array(
        'nulable' => true,
    ), 'Category Page Image Text')
    ->addColumn('product_image_text_styles', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nulable' => true,
    ), 'Product Page Image Text Styles')
    ->addColumn('category_image_text_styles', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nulable' => true,
    ), 'Category Page Image Text Styles')
    ->addColumn('conditions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nulable' => true,
    ), 'Label Conditions')
    ->addColumn('is_on_sale', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nulable' => false,
        'default' => 0,
    ), 'On Sale Condition')
    ->addColumn('minimum_discount', Varien_Db_Ddl_Table::TYPE_SMALLINT, 3, array(
        'nulable' => true,
    ), 'Minimum Discount')
    ->addColumn('maximum_discount', Varien_Db_Ddl_Table::TYPE_SMALLINT, 3, array(
        'nulable' => true,
    ), 'Maximum Discount')
    ->addColumn('is_new', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nulable' => false,
        'default' => 0,
    ), 'Is New Condition')
    ->addColumn('is_new_default', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nulable' => false,
        'default' => 0,
    ), 'Use Default Dates')
    ->addColumn('is_new_starting_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Is New Starting Date')
    ->addColumn('is_new_ending_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Is New Ending Date');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('rc_label/index'))
    ->addColumn('label_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        'comment'   => 'Label ID'
        ), 'Label ID')    
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        'comment'   => 'Product ID'
        ), 'Product ID')
    ->addColumn('category_page_text', Varien_Db_Ddl_Table::TYPE_TEXT, 256, array(
        'nulable' => true,
        ), 'Category Page Processed Text')
    ->addColumn('product_page_text', Varien_Db_Ddl_Table::TYPE_TEXT, 256, array(
        'nulable' => true,
        ), 'Product Page Processed Text')
    ->addColumn('initiation_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true
        ), 'Initiation Date')
    ->addColumn('expiration_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true
        ), 'Expiration Date')
    ->setComment('Labels Index Table');

$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('rc_label/index_tmp'))
    ->addColumn('label_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        'comment'   => 'Label ID'
        ), 'Label ID')    
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        'comment'   => 'Product ID'
        ), 'Product ID')   
    ->addColumn('category_page_text', Varien_Db_Ddl_Table::TYPE_TEXT, 256, array(
            'nulable' => true,
        ), 'Category Page Processed Text')
    ->addColumn('product_page_text', Varien_Db_Ddl_Table::TYPE_TEXT, 256, array(
            'nulable' => true,
        ), 'Product Page Processed Text')
    ->addColumn('initiation_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true
        ), 'Initiation Date')
    ->addColumn('expiration_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true
        ), 'Expiration Date')
    ->setComment('Labels Index Temporary Table');

$installer->getConnection()->createTable($table);

$installer->getConnection()->addConstraint('FK_RC_LABEL_INDEX_LABEL_ENTITY',
    $installer->getTable('rc_label/index'), 'label_id',
    $installer->getTable('rc_label/label'), 'label_id'
);
$installer->getConnection()->addConstraint('FK_RC_LABEL_INDEX_PRODUCT_ENTITY',
    $installer->getTable('rc_label/index'), 'product_id',
    $installer->getTable('catalog_product_entity'), 'entity_id'
);

$installer->getConnection()->addConstraint('FK_LABEL_INDEX_TMP_LABEL_ENTITY',
    $installer->getTable('rc_label/index_tmp'), 'label_id',
    $installer->getTable('rc_label/label'), 'label_id'
);
$installer->getConnection()->addConstraint('FK_LABEL_INDEX_TMP_PRODUCT_ENTITY',
    $installer->getTable('rc_label/index_tmp'), 'product_id',
    $installer->getTable('catalog_product_entity'), 'entity_id'
);

$installer->endSetup();
