<?php
/**
 * Shop install migration
 * Класс миграций для модуля Shop:
 *
 * @category YupeMigration
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.shop.models
 * @since 0.1
 * @editor Poltoratskiy A. <co11ter@mail.ru>
 **/
class m000000_000000_good_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable('{{shop_good}}', array(
                'id' => 'pk',
                'category_id' => 'integer DEFAULT NULL',
                'name' => 'varchar(250) NOT NULL',
                'price' => "decimal(19,2) NOT NULL DEFAULT '0'",
                'article' => 'varchar(100) DEFAULT NULL',
                'image' => 'varchar(250) DEFAULT NULL',
                'short_description' => 'text',
                'description' => 'text NOT NULL',
                'alias' => 'varchar(150) NOT NULL',
                'data' => 'text',
                'is_special' => "boolean NOT NULL DEFAULT '0'",
                'status' => "boolean NOT NULL DEFAULT '1'",
                'create_time' => 'datetime NOT NULL',
                'update_time' => 'datetime NOT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'change_user_id' => 'integer DEFAULT NULL',
            ), $this->getOptions()
        );

        $this->createTable('{{shop_good_has_attribute}}', array(
                'id' => 'pk',
                'good_id' => 'int NOT NULL',
                'attribute_id' => 'int NOT NULL',
                'value' => 'varchar(250) NOT NULL',
            ), $this->getOptions()
        );

        $this->createIndex("ux_{{shop_good}}_alias", '{{shop_good}}', "alias", true);
        $this->createIndex("ix_{{shop_good}}_status", '{{shop_good}}', "status", false);
        $this->createIndex("ix_{{shop_good}}_category", '{{shop_good}}', "category_id", false);
        $this->createIndex("ix_{{shop_good}}_user", '{{shop_good}}', "user_id", false);
        $this->createIndex("ix_{{shop_good}}_change_user", '{{shop_good}}', "change_user_id", false);
        $this->createIndex("ix_{{shop_good}}_article", '{{shop_good}}', "article", false);
        $this->createIndex("ix_{{shop_good}}_price", '{{shop_good}}', "price", false);

        $this->addForeignKey("fk_{{shop_good}}_user",'{{shop_good}}', 'user_id', '{{user_user}}', 'id', 'SET NULL', 'NO ACTION');
        $this->addForeignKey("fk_{{shop_good}}_change_user",'{{shop_good}}', 'change_user_id','{{user_user}}', 'id', 'SET NULL', 'NO ACTION');
        $this->addForeignKey("fk_{{shop_good}}_category",'{{shop_good}}', 'category_id', '{{category_category}}', 'id', 'SET NULL', 'NO ACTION');

        $this->addForeignKey("fk_{{shop_good_has_attribute}}_good", '{{shop_good_has_attribute}}', 'good_id', '{{shop_good}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_{{shop_good_has_attribute}}_attribute", '{{shop_good_has_attribute}}', 'attribute_id', '{{attribute_attribute}}', 'id', 'CASCADE', 'CASCADE');
    }
 
    /**
     * Откат миграции:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{shop_good_has_attribute}}');
        $this->dropTableWithForeignKeys('{{shop_good}}');
    }
}