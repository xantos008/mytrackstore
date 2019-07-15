<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;

$this->title = Yii::t('app','Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<div class="top_wrapper loginfo">
	<div class="container">
		<div class="ball1"></div>
		<div class="row">
			<div class="col-lg-12 backfologin">
			<h1><?= Yii::t('app', Html::encode($this->title)) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'Логин')])->label(false) ?>

                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app','Пароль')])->label(false) ?>
				
				<?= $form->field($model, 'regip')->textInput(['type' => 'hidden', 'value' => $_SERVER['REMOTE_ADDR']])->label(false)  ?>
				<?= $form->field($model, 'lastip')->textInput(['type' => 'hidden', 'value' => $_SERVER['REMOTE_ADDR']])->label(false)  ?>
				<?= $form->field($model, 'checkmailcode')->textInput(['type' => 'hidden', 'value' => generateRandomString()])->label(false)  ?>
				<?= $form->field($model, 'confirmemail')->textInput(['type' => 'hidden', 'value' => 0])->label(false)  ?>
				<?= $form->field($model, 'created_at_shifr')->textInput(['type' => 'hidden', 'value' => date('Y-m-d H:i:s')])->label(false)  ?>

				
				<div class="checkboxes towhite">
					<input name="privacy" type="checkbox" id="privacy" class="checkbox" required checked>
					<label for="privacy"><a href="/about"><?=Yii::t('app','Я принимаю Лицензионное соглашение')?></a></label>
				</div>
				
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','Регистрация'), ['class' => 'btn button-cart aee', 'name' => 'signup-button']) ?>
                </div>
				
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
<div class="site-index">