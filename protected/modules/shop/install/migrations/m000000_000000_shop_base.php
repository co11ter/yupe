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
class m000000_000000_shop_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        // таблица содержащая "товар"
        $this->createTable('{{shop_good}}', array(
                'id' => 'pk',
                'category_id' => 'integer DEFAULT NULL',
                'name' => 'varchar(250) NOT NULL',
                'alias' => 'varchar(150) NOT NULL',
                'meta_description' => 'text',
                'meta_keywords' => 'text',
                'article' => 'varchar(100) DEFAULT NULL',
                'status' => 'boolean NOT NULL DEFAULT \'0\'',
                'external_id' => 'varchar(64) DEFAULT NULL'
            ), $this->getOptions()
        );

        // таблица содержащая "торговые предложения"
        $this->createTable('{{shop_offer}}', array(
                'id' => 'pk',
                'good_id' => 'integer DEFAULT NULL',
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
                'gallery_id' => 'integer DEFAULT NULL',
                'external_id' => 'varchar(64) DEFAULT NULL'
            ), $this->getOptions()
        );

        // таблица со значениями атрибутов товара
        $this->createTable('{{shop_offer_has_attribute}}', array(
                'id' => 'pk',
                'offer_id' => 'int NOT NULL',
                'attribute_id' => 'int NOT NULL',
                'value' => 'varchar(250) NOT NULL',
            ), $this->getOptions()
        );

        $this->createIndex("ux_{{shop_offer}}_alias", '{{shop_offer}}', "alias", true);
        $this->createIndex("ix_{{shop_offer}}_status", '{{shop_offer}}', "status", false);
        $this->createIndex("ix_{{shop_good}}_category", '{{shop_good}}', "category_id", false);
        $this->createIndex("ix_{{shop_offer}}_user", '{{shop_offer}}', "user_id", false);
        $this->createIndex("ix_{{shop_offer}}_change_user", '{{shop_offer}}', "change_user_id", false);
        $this->createIndex("ix_{{shop_offer}}_article", '{{shop_offer}}', "article", false);
        $this->createIndex("ix_{{shop_offer}}_price", '{{shop_offer}}', "price", false);

        $this->addForeignKey("fk_{{shop_offer}}_user",'{{shop_offer}}', 'user_id', '{{user_user}}', 'id', 'SET NULL', 'NO ACTION');
        $this->addForeignKey("fk_{{shop_offer}}_change_user",'{{shop_offer}}', 'change_user_id','{{user_user}}', 'id', 'SET NULL', 'NO ACTION');
        $this->addForeignKey("fk_{{shop_offer}}_category",'{{shop_good}}', 'category_id', '{{category_category}}', 'id', 'SET NULL', 'NO ACTION');
        $this->addForeignKey("fk_{{shop_offer}}_gallery",'{{shop_offer}}', 'gallery_id', '{{gallery_gallery}}', 'id', 'SET NULL', 'NO ACTION');
        $this->addForeignKey("fk_{{shop_offer}}_good",'{{shop_offer}}', 'good_id', '{{shop_good}}', 'id', 'SET NULL', 'NO ACTION');

        $this->addForeignKey("fk_{{shop_offer_has_attribute}}_offer", '{{shop_offer_has_attribute}}', 'offer_id', '{{shop_offer}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_{{shop_offer_has_attribute}}_attribute", '{{shop_offer_has_attribute}}', 'attribute_id', '{{attribute_attribute}}', 'id', 'CASCADE', 'CASCADE');
    }
 
    /**
     * Откат миграции:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{shop_offer_has_attribute}}');
        $this->dropTableWithForeignKeys('{{shop_offer}}');
        $this->dropTableWithForeignKeys('{{shop_good}}');
    }
}