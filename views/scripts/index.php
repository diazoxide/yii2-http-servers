<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel diazoxide\yii2hhm\models\ScriptsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scripts';
$this->params['breadcrumbs'][] = ['label' => 'Servers', 'url' => '@web/servers'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scripts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Scripts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            ['attribute' => 'servers.count', 'format' => 'raw', 'value' => function ($model) {
                $html = '';
                foreach ($model->servers as $server) {
                    $html .= Html::a($server->name, ['/servers/default/view', 'id' => $server->id]);
                    $html .= '<br>';
                }
                return $html;
            }],
            ['attribute' => 'status','filter'=>[0=>'Disabled',1=>'Enabled'], 'value' => function ($model) {
                return $model->status ? "Enabled" : "Disabled";
            }],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
