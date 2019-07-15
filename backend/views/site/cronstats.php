<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;
?>

<?php
$users = User::find()->where(['status' => 10])->all();
$users_premium = User::find()->where(['<>', 'premium', 0])->all();

	foreach($users_premium as $key=>$value){
		if(date('Y-m-d') < date('Y-m-d',strtotime('+30 days',strtotime($value->premiumdate))) . PHP_EOL){
			$mufasa = User::find()->where(['id'=>$value->id])->all();
			$mufasa->stat_is_premium = 1;
			$mufasa->save();
		} else {
			$mufasa = User::find()->where(['id'=>$value->id])->all();
			$mufasa->stat_is_premium = 0;
			$mufasa->save();
		}
		
		if(date('Y-m-d') < date('Y-m-d',strtotime('+30 days',strtotime($value->premiumdate))) . PHP_EOL && date('Y-m-d') > date('Y-m-d',strtotime('+25 days',strtotime($value->premiumdate))) . PHP_EOL ){
			$mufasa = User::find()->where(['id'=>$value->id])->all();
			$mufasa->stat_less_five_days = 1;
			$mufasa->save();
		} else {
			$mufasa = User::find()->where(['id'=>$value->id])->all();
			$mufasa->stat_less_five_days = 0;
			$mufasa->save();
		}
		
		if($value->premium < 5){
			$mufasa = User::find()->where(['id'=>$value->id])->all();
			$mufasa->stat_less_five_dawnload = 1;
			$mufasa->save();
		} else {
			$mufasa = User::find()->where(['id'=>$value->id])->all();
			$mufasa->stat_less_five_dawnload = 0;
			$mufasa->save();
		}
	}
?>

<p class="succes-send">Статистика обновлена!</p>