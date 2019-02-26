<?php

namespace diazoxide\yii2hhm\models;

use Yii;

/**
 * This is the model class for table "{{%hosts_servers}}".
 *
 * @property int $id
 * @property string $name
 * @property string $ip
 * @property string $logs
 * @property string $cache_exceptions
 * @property boolean $cache
 * @property boolean $compress
 * @property boolean $debug
 * @property integer $cache_expire
 * @property Scripts[] $scripts
 * @property Rules[] $rules
 */
class Servers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%servers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['scripts_ids'], 'each', 'rule' => ['integer']],
            [['rules_ids'], 'each', 'rule' => ['integer']],
            [['name', 'ip'], 'required'],
            [['name', 'ip'], 'string', 'max' => 255],
            [['debug', 'cache', 'logs','compress'], 'boolean'],
            [['cache_expire'], 'integer'],
            [['cache_exceptions'], 'string'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => \voskobovich\behaviors\ManyToManyBehavior::className(),
                'relations' => [
                    'scripts_ids' => 'scripts',
                    'rules_ids' => 'rules',
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ip' => 'Ip address',
            'debug' => 'Debug',
            'logs' => 'Logs',
            'cache' => 'Cache',
            'compress' => 'Compress',
            'cache_expire' => 'Cache Expire',
            'scripts_ids' => 'Scripts',
            'rules_ids' => 'Redirects',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getScripts()
    {
        return $this->hasMany(Scripts::className(), ['id' => 'script_id'])
            ->viaTable('{{%servers_scripts_map}}', ['server_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getRules()
    {
        return $this->hasMany(Rules::className(), ['id' => 'rule_id'])
            ->viaTable('{{%servers_rules_map}}', ['server_id' => 'id']);
    }


    public function getLogs()
    {
        return $this->hasMany(ServersLogs::className(), ['server_id' => 'id']);
    }
}
