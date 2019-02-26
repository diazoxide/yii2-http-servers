<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104750_servers_logs extends Migration
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
            '{{%servers_logs}}',
            [
                'id'=> $this->primaryKey(11),
                'server_id'=> $this->integer(11)->notNull(),
                'ip_address'=> $this->string(50)->notNull(),
                'url'=> $this->string(2083)->notNull(),
                'referer'=> $this->string(2083)->null()->defaultValue(null),
                'user_agent'=> $this->string(512)->notNull(),
                'sign_date'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
                'request_duration'=> $this->decimal(11, 11)->unsigned()->notNull(),
                'response_duration'=> $this->decimal(11, 11)->unsigned()->notNull(),
                'status'=> $this->integer(3)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%servers_logs}}');
    }
}
