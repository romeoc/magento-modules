<?php

namespace RC\Offices\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * RC Offices schema installation
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
    * Adding the "rc_offices" table
     * 
    * @param SchemaSetupInterface $setup
    * @param ModuleContextInterface $context
    */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable('rc_offices'))
            ->addColumn(
                'office_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Office ID'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                128,
                ['nullable' => false, 'default' => ''],
                'Office Name'
            )
            ->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                1024,
                ['nullable' => true, 'default' => ''],
                'Office Description'
            )
            ->addColumn(
                'image',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                128,
                ['nullable' => true, 'default' => ''],
                'Office Description'
            )
            ->addColumn(
                'origin',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                8,
                ['nullable' => false, 'default' => ''],
                'Office Description'
            )->setComment("RC Offices");
        $setup->getConnection()->createTable($table);
    }
}
