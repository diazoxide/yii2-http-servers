<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model diazoxide\yii2hhm\models\Servers */
/* @var $logs diazoxide\yii2hhm\models\ServersLogs */
/* @var $logsSearchModel diazoxide\yii2hhm\models\ServersLogsSearch */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Servers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'ip',
        ],
    ]) ?>

    <h2>Logs</h2>
    <?= GridView::widget([
        'dataProvider' => $logsDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ip_address',
            [
                'attribute' => 'referer',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(\yii\helpers\StringHelper::truncate($model->referer, '25', '...'), $model->referer, ['target' => '_blank']);
                }
            ],
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(\yii\helpers\StringHelper::truncate($model->url, '25', '...'), $model->url, ['target' => '_blank']);
                }
            ],
            [
                'attribute' => 'sign_date',
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('span', Yii::$app->formatter->asRelativeTime($model->sign_date), ['class' => 'label label-default', 'data-toggle' => "tooltip", 'title' => $model->sign_date]);
                }
            ],
        ],
    ]); ?>
</div>
