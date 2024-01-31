<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'me_cmb'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('me_cmb')
        )->addColumn(
            'cmb_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Cmb ID'
        )->addColumn(
            'cmb_full_name',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false,
                'default' => null
            ],
            'Full Name'
        )->addColumn(
            'cmb_telephone',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false,
                'default' => null
            ],
            'Telephone'
        )->addColumn(
            'cmb_call_date',
            Table::TYPE_DATE,
            null,
            [
                'nullable' => true
            ],
            'Call Date'
        )->addColumn(
            'cmb_predefined',
            Table::TYPE_TEXT,
            null,
            [
                'nullable' => true,
                'default' => null
            ],
            'Predefined Time'
        )->addColumn(
            'cmb_country',
            Table::TYPE_TEXT,
            2,
            [
                'nullable' => true,
                'default' => null
            ],
            'Country'
        )->addColumn(
            'cmb_status',
            Table::TYPE_SMALLINT,
            null,
            [
                'nullable' => false,
                'default' => '0'
            ],
            'Status'
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false
            ],
            'Store Id'
        )->addColumn(
            'cmb_posted_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT
            ],
            'Post Time'
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('me_cmb'),
                ['cmb_full_name', 'cmb_telephone'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['cmb_full_name', 'cmb_telephone'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->addForeignKey(
            $installer->getFkName(
                'me_cmb',
                'store_id',
                'store',
                'store_id'
            ),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        )->setComment(
            'Me Cmb Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
