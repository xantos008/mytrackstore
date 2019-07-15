<?php
/* @var $this yii\web\View */
/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Купить премиум аккаунт');
$this->params['breadcrumbs'][] = $this->title;
//$model = Yii::$app->user->identity;
?>

<div class="site-reset-password site-login col-lg-8">
    <h1><?= Html::encode($this->title) ?></h1>

    <div style="margin: 0 0 25px 0;"></div>
	
	<p class="lead" style="margin-top:35px;padding: 0 40px;">Приобретите премиум аккаунт и получайте дополнительные бонусы, опыт и золото.</p>
	
    <div class="row">
        <div class="col-lg-12">
			
			<?php $form = ActiveForm::begin(); ?>
 
			<?= $form->field($model, 'premium')->dropDownList([
					date('Y-m-d', strtotime(date("Y-m-d").' +1 month')) => '1 месяц - 300 рублей',
					date('Y-m-d', strtotime(date("Y-m-d").' +2 month')) => '2 месяц - 600 рублей',
					date('Y-m-d', strtotime(date("Y-m-d").' +3 month')) =>'3 месяц - 900 рублей'
				])->label(false) ?>
			 
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'Купить премиум аккаунт'), ['class' => 'btn btn-primary']) ?>
			</div>
			
			<div class="form-group lead">
				<?= Html::a('Вернуться назад', ['/profile']) ?>
			</div>
			 
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="site-index">
 

