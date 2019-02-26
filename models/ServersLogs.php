<?php

namespace diazoxide\yii2hhm\models;

use Yii;

/**
 * This is the model class for table "{{%servers_logs}}".
 *
 * @property int $id
 * @property int $request_duration
 * @property int $response_duration
 * @property int $server_id
 * @property string $ip_address
 * @property string $url
 * @property string $referer
 * @property string $user_agent
 * @property string $sign_date
 * @property int $status
 */

class ServersLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%servers_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['server_id', 'ip_address', 'url', 'user_agent', 'status'], 'required'],
            [['server_id', 'status'], 'integer'],
            [['request_duration', 'response_duration'], 'number'],
            [['sign_date'], 'safe'],
            [['ip_address'], 'string', 'max' => 50],
            [['url','referer'], 'string', 'max' => 2083],
            [['user_agent'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'server_id' => 'Server ID',
            'ip_address' => 'Ip Address',
            'url' => 'Url',
            'referer'=>'Referer',
            'user_agent' => 'User Agent',
            'sign_date' => 'Sign Date',
            'status' => 'Status',
        ];
    }
}
