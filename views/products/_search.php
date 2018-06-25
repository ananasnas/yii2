<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\productsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_product') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'frozen') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'Categories_ID_category') ?>

    <?php // echo $form->field($model, 'WasDel') ?>

    <?php // echo $form->field($model, 'activate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
