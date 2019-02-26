<?php

namespace diazoxide\yii2hhm\models;

use Yii;

/**
 * This is the model class for table "{{%servers_scripts}}".
 *
 * @property int $id
 * @property string $name
 * @property string $script
 * @property int $status
 * @property string $content_types
 * @property boolean $append
 * @property Servers $servers
 */
class Scripts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%servers_scripts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['servers_ids'], 'each', 'rule' => ['integer']],

            [['name', 'script', 'status'], 'required'],
            [['script'], 'string'],
            [['append'], 'boolean'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['content_types'], 'string'],
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => \voskobovich\behaviors\ManyToManyBehavior::className(),
                'relations' => [
                    'servers_ids' => 'servers',
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
            'script' => 'Script',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServers() {
        return $this->hasMany(Servers::className(), ['id' => 'server_id'])
            ->viaTable('{{%servers_scripts_map}}', ['script_id' => 'id']);
    }
}
