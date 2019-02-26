<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104751_servers_rules extends Migration
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
            '{{%servers_rules}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(255)->notNull(),
                'match'=> $this->text()->notNull(),
                'redirect'=> $this->tinyInteger(1)->notNull(),
                'clean'=> $this->tinyInteger(1)->notNull(),
                'remote_content'=> $this->tinyInteger(1)->notNull(),
                'server_content'=> $this->tinyInteger(1)->notNull(),
                'to'=> $this->text()->notNull(),
                'content_type'=> $this->string(255)->notNull(),
                'priority'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%servers_rules}}');
    }
}
