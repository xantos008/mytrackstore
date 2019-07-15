<?php
/* @var $this yii\web\View */
/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Привязать номер телефона');
$this->params['breadcrumbs'][] = $this->title;
//$model = Yii::$app->user->identity;
?>

<div class="site-reset-password site-login col-lg-8">
    <h1><?= Html::encode($this->title) ?></h1>

    <div style="margin: 0 0 25px 0;"></div>
	
    <div class="row">
        <div class="col-lg-12">
			<?php $form = ActiveForm::begin(); ?>
 
			<?= $form->field($model, 'phone')->input('phone', ['maxlength' => true, 'placeholder' => 'Новый телефон'])->label(false) ?>
			 
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'Изменить'), ['class' => 'btn btn-primary']) ?>
			</div>
			
			<div class="form-group lead">
				<?= Html::a('Вернуться назад', ['/profile']) ?>
			</div>
			 
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="site-index">
 

