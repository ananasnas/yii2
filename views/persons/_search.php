<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\personsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persons-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_person') ?>

    <?= $form->field($model, 'surname') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?= $form->field($model, 'login') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'mail') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'not_availble_start') ?>

    <?php // echo $form->field($model, 'not_availble_finish') ?>

    <?php // echo $form->field($model, 'count_of_open_orders') ?>

    <?php // echo $form->field($model, 'Organizations_ID_organization') ?>

    <?php // echo $form->field($model, 'Groups_ID_group') ?>

    <?php // echo $form->field($model, 'Sessions_ID_session') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'WasDel') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
