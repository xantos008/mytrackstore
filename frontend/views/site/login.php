<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Авторизация');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
    if (Yii::$app->getSession()->hasFlash('error')) {
        echo '<div class="alert alert-danger">'.Yii::$app->getSession()->getFlash('error').'</div>';
    }
?>

<div class="top_wrapper loginfo">
	<div class="container">
		<div class="ball1"></div>
		<div class="row">
			<div class="col-lg-12 backfologin">
				<h1><?= Yii::t('app', Html::encode($this->title)) ?></h1>
				<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

				<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'Логин')])->label(false)  ?>

				<?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app','Пароль')])->label(false) ?>
								
				<div class="width80">
					<div class="inline margin50 towhite">
						<?= Html::a(Yii::t('app','Забыли пароль?'), ['site/request-password-reset']) ?>
					</div>

					<div class="form-group inline margin50">
						<?= Html::submitButton(Yii::t('app','Войти'), ['class' => 'btn button-cart btn-login-small', 'name' => 'login-button']) ?>
					</div>
					<div class="regs-n-socials towhite">
						<p class="lead"><a href="/signup"><?=Yii::t('app','Зарегистрировать новый аккаунт')?></a></p>
					</div>
				</div>

				<?php ActiveForm::end(); ?>
				
			</div>
		</div>
	</div>
</div>
<div class="site-index">
