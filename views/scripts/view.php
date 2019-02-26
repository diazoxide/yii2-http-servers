<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2hhm\models\Scripts */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Scripts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scripts-view">

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

    <?= trntv\aceeditor\AceEditor::widget([
        // You can either use it for model attribute
        'model' => $model,
        'attribute' => 'script',
        'mode'=>'javascript', // programing language mode. Default "html"
        'theme'=>'github', // editor theme. Default "github"
        'readOnly'=>'true' // Read-only mode on/off = true/false. Default "false"
    ]); ?>

</div>
