<?php
namespace Ocode\CustomJewelry\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Check if the table already exists
        if (!$setup->tableExists('ocode_custom_jewelry_form')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('ocode_custom_jewelry_form')
            )
            ->addColumn(
                'form_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Form ID'
            )
            ->addColumn(
                'fname',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'First Name'
            )
            ->addColumn(
                'lname',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Last Name'
            )
            ->addColumn(
                'email',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Email Address'
            )
            ->addColumn(
                'phone_number',
                Table::TYPE_TEXT,
                20,
                ['nullable' => false],
                'Phone Number'
            )
            ->addColumn(
                'like_to_design',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'What Would You Like to Design'
            )
            ->addColumn(
                'when_finished_piece',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'When Do You Need the Finished Piece'
            )
            ->addColumn(
                'custom_vision',
                Table::TYPE_TEXT,
                '64k',
                ['nullable' => true],
                'Tell Us About Your Custom Vision'
            )
            ->setComment('Custom Jewelry Form Table');

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
