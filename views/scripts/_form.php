<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model diazoxide\yii2hhm\models\Scripts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scripts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'script')->widget(
        'trntv\aceeditor\AceEditor',
        [
            'mode'=>'javascript', // programing language mode. Default "html"
            'theme'=>'github', // editor theme. Default "github"
            //'readOnly'=>'true' // Read-only mode on/off = true/false. Default "false"
        ]
    ) ?>

    <?= $form->field($model, 'content_types')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'append')->checkbox() ?>


    <?= $form->field($model, 'servers_ids')->checkboxlist(ArrayHelper::map(\diazoxide\yii2hhm\models\Servers::find()->all(), 'id', 'name'),['separator'=>'</br>']);?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
