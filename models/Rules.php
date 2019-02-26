<?php

namespace diazoxide\yii2hhm\models;

use Yii;

/**
 * This is the model class for table "{{%servers_redirects}}".
 *
 * @property int $id
 * @property string $match
 * @property boolean $redirect
 * @property string $to
 * @property string $clean
 * @property string $server_content
 * @property string $remote_content
 * @property string $content_type
 */
class Rules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%servers_rules}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['servers_ids'], 'each', 'rule' => ['integer']],
            [['match', 'name'], 'required'],

            ['to', 'required', 'when' => function ($model) {
                return $model->redirect;
            }, 'enableClientValidation' => false],

//            ['content_type', 'required', 'when' => function ($model) {
//                return !$model->redirect;
//            }, 'enableClientValidation' => false],

            [['priority'], 'integer'],

            [['redirect', 'clean', 'server_content', 'remote_content'], 'boolean'],

            [['match', 'to'], 'string'],
            [['name', 'content_type'], 'string', 'max' => 255],
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
            'match' => 'Match',
            'to' => 'To',
        ];
    }

    public function getServers()
    {
        return $this->hasMany(Servers::className(), ['id' => 'server_id'])
            ->viaTable('{{%servers_rules_map}}', ['rule_id' => 'id']);
    }
}
