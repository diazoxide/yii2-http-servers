<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2hhm\models\Scripts */

$this->title = 'Update Scripts: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Scripts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scripts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
