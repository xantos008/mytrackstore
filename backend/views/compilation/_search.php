<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CompilationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="compilation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'picture') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'audio') ?>

    <?php // echo $form->field($model, 'buttontext') ?>

    <?php // echo $form->field($model, 'metatitle') ?>

    <?php // echo $form->field($model, 'metadescription') ?>

    <?php // echo $form->field($model, 'metakeywords') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
