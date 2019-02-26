<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel diazoxide\yii2hhm\models\RulesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rules-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'match:ntext',
            [
                'attribute' => 'clean',
                'value' => function ($model) {
                    return $model->clean ? "Yes" : "No";
                }
            ],
            [
                'attribute' => 'redirect',
                'value' => function ($model) {
                    return $model->redirect ? "Yes" : "No";
                }
            ],
            [
                'attribute' => 'server_content',
                'value' => function ($model) {
                    return $model->server_content ? "Yes" : "No";
                }
            ],
            [
                'attribute' => 'remote_content',
                'value' => function ($model) {
                    return $model->remote_content ? "Yes" : "No";
                }
            ],
            //'to:ntext',
            'priority',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
