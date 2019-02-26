<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model diazoxide\yii2hhm\models\Rules */

$this->title = 'Create Redirects';
$this->params['breadcrumbs'][] = ['label' => 'Redirects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redirects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
