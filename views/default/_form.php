<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2hhm\models\Servers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servers-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">

        <div class="col-sm-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'cache')->checkbox() ?>

            <?= $form->field($model, 'cache_exceptions')->textarea() ?>


            <?= $form->field($model, 'cache_expire')->textInput(['type' => 'number']) ?>


            <?= $form->field($model, 'compress')->checkbox() ?>

            <?= $form->field($model, 'logs')->checkbox() ?>

            <?= $form->field($model, 'debug')->checkbox() ?>

        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'scripts_ids')->checkboxlist(ArrayHelper::map(\diazoxide\yii2hhm\models\Scripts::find()->all(), 'id', 'name'),['separator'=>'</br>']);?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'rules_ids')->checkboxlist(ArrayHelper::map(\diazoxide\yii2hhm\models\Rules::find()->all(), 'id', 'name'),['separator'=>'</br>']);?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
