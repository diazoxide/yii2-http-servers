<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104749_servers extends Migration
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
            '{{%servers}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(255)->notNull(),
                'ip'=> $this->string(255)->notNull(),
                'debug'=> $this->tinyInteger(1)->notNull(),
                'logs'=> $this->tinyInteger(1)->notNull(),
                'cache'=> $this->tinyInteger(1)->notNull(),
                'cache_expire'=> $this->integer(11)->notNull(),
                'cache_exceptions'=> $this->text()->notNull(),
                'compress'=> $this->tinyInteger(1)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%servers}}');
    }
}
