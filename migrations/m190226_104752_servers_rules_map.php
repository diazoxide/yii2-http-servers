<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104752_servers_rules_map extends Migration
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
            '{{%servers_rules_map}}',
            [
                'id'=> $this->primaryKey(11),
                'server_id'=> $this->integer(11)->notNull(),
                'rule_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%servers_rules_map}}');
    }
}
