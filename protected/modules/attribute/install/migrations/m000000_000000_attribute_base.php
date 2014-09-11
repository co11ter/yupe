<?php
/**
 * Attribute install migration
 * Класс миграций для модуля Attribute:
 *
 * @category YupeMigration
 * @package  yupe.modules.attribute.install.migrations
 * @author   Poltoratskiy A. <co11ter@mail.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 **/
class m000000_000000_attribute_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable('{{attribute_attribute}}', array(
                'id' => 'pk',
                'name' => 'varchar(250) NOT NULL',
                'type_id' => 'int(11) DEFAULT 1', // default type is string (Attribute::TYPE_STRING)
                'value_list' => 'varchar(1024) DEFAULT NULL'
            ), $this->getOptions()
        );

        $this->createTable('{{attribute_category_has_attribute}}', array(
                'category_id' => 'int NOT NULL',
                'attribute_id' => 'int NOT NULL',
                'for_filter' => 'int(1) DEFAULT 0',
                'sort' => 'int(3) DEFAULT 100',
                'PRIMARY KEY (`category_id`, `attribute_id`)',
            ), $this->getOptions()
        );

        $this->addForeignKey("fk_{{attribute_category_has_attribute}}_category", '{{attribute_category_has_attribute}}', 'category_id', '{{category_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_{{attribute_category_has_attribute}}_attribute", '{{attribute_category_has_attribute}}', 'attribute_id', '{{attribute_attribute}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * Откат миграции:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{attribute_category_has_attribute}}');
        $this->dropTableWithForeignKeys('{{attribute_attribute}}');
    }
}