<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PackagelistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="packagelist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'package_id') ?>

    <?= $form->field($model, 'rstl_id') ?>

    <?= $form->field($model, 'testcategory_id') ?>

    <?= $form->field($model, 'sample_type_id') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'tests') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
