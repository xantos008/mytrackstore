<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app','Изменение пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="top_wrapper loginfo">
	<div class="container">
		<div class="ball1"></div>
		<div class="row">
			<div class="col-lg-12 backfologin">
			
			<h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','Изменить пароль'), ['class' => 'btn button-cart aee']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
<div class="site-index">