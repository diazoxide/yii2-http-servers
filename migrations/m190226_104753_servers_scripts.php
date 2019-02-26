<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104753_servers_scripts extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%servers_scripts}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(255)->notNull(),
                'script'=> $this->text()->notNull(),
                'content_types'=> $this->text()->notNull(),
                'append'=> $this->tinyInteger(1)->notNull(),
                'status'=> $this->tinyInteger(1)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%servers_scripts}}');
    }
}
