<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Логин') ?>
	
	<div class="form-group">
		<label class="control-label">Пароль</label>
		<input type="password" class="form-control" name="User[password]" maxlength="255" aria-invalid="false" type="text">
	</div>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('E-mail') ?>
	
    <?= $form->field($model, 'regip')->textInput(['maxlength' => true])->label('IP адрес администратора') ?>
	
    <?= $form->field($model, 'ifadminname')->textInput(['maxlength' => true])->label('Имя администратора') ?>

    <?= $form->field($model, 'status')->textInput(['type'=>'hidden', 'value' => 10])->label('')->error(false) ?>
	<h3>Основная информация</h3>
	<p>Социальные сети</p>
	
	<?= $form->field($model, 'instagramm')->textInput(['maxlength' => true])->label('Instagram') ?>
	
	<?= $form->field($model, 'twitter')->textInput(['maxlength' => true])->label('Twitter') ?>
	
	<?= $form->field($model, 'facebook')->textInput(['maxlength' => true])->label('Facebook') ?>
	
	<?= $form->field($model, 'googleplus')->textInput(['maxlength' => true])->label('Googleplus') ?>
	
	<?= $form->field($model, 'skype')->textInput(['maxlength' => true])->label('Skype') ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Телефон') ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать администратора') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
