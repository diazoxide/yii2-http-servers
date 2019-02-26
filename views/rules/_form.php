<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2hhm\models\Rules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'match')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content_type')->textInput() ?>


    <?= $form->field($model, 'redirect')->checkbox(['onchange' => '$(".field-rules-to").toggle()']) ?>

    <?= $form->field($model, 'to', ['options' => ['style' => !$model->redirect ? 'display:none' : ""]])->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'clean')->checkbox() ?>

    <?= $form->field($model, 'server_content')->checkbox() ?>

    <?= $form->field($model, 'remote_content')->checkbox() ?>


    <?= $form->field($model, 'priority')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'servers_ids')->checkboxlist(ArrayHelper::map(\diazoxide\yii2hhm\models\Servers::find()->all(), 'id', 'name'), ['separator' => '</br>']); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
