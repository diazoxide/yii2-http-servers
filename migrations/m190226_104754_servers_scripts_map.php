<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104754_servers_scripts_map extends Migration
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
            '{{%servers_scripts_map}}',
            [
                'id'=> $this->primaryKey(11),
                'server_id'=> $this->integer(11)->notNull(),
                'script_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%servers_scripts_map}}');
    }
}
