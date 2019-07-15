<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app','Восстановление пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="top_wrapper loginfo">
	<div class="container">
		<div class="ball1"></div>
		<div class="row">
			<div class="col-lg-12 backfologin">
			
			<h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','Восстановить'), ['class' => 'btn button-cart aee']) ?>
                </div>
				
				<div class="form-group lead">
                    <?= Html::a(Yii::t('app','Вернуться назад'), ['site/login']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
<div class="site-index">