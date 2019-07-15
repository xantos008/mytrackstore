<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use app\models\Tournament;
use app\models\Commands;
use common\models\Blacklist;
$blacklist = Blacklist::find()->all();

$handle = @fopen(explode('frontend',$_SERVER['DOCUMENT_ROOT'])[0].".htaccess", "w+");
if ($handle) {
	$ips = '';
	foreach($blacklist as $key => $value){
		$ips .= "deny from ".$value->ip."
 ";
	}
	$text = 'AddDefaultCharset UTF-8
 
Options -Indexes
 
RewriteEngine On
 
RewriteCond %{REQUEST_URI} ^/(admin)
RewriteRule ^admin(\/?.*)$ backend/web/$1 [L]
 
RewriteCond %{REQUEST_URI} ^/
RewriteRule ^(\/?.*)$ frontend/web/$1 [L]

<Limit GET POST>
 order allow,deny
 '.$ips.'allow from all
</Limit>
	';
	
	fwrite($handle, $text);
    fclose($handle);
}
class TournamentsController extends \yii\web\Controller
{
	
    public function actionIndex()
    {
		$check = Tournament::find()->where(['status'=>10])->all();
		foreach($check as $key => $value){
			if(date("Y-m-d", strtotime($value->dateend)) < date("Y-m-d")){
				$change = Tournament::findOne($value->id);
				$change->status = 0;
				$change->update();
			}
		}
        return $this->render('index');
    }
	
	public function actionTurnir($id)
    {
		$check = Tournament::find()->where(['status'=>10])->all();
		foreach($check as $key => $value){
			if(date("Y-m-d", strtotime($value->dateend)) < date("Y-m-d")){
				$change = Tournament::findOne($value->id);
				$change->status = 0;
				$change->update();
			}
		}
		$tournament = Tournament::findOne($id);
		if ($tournament === null || date("Y-m-d", strtotime($tournament->dateend)) < date("Y-m-d"))
            return Yii::$app->response->redirect(['/404']);
		
		$name = $tournament->name; //имя
		$members = ($tournament->members);

		$date_start = $tournament->datestart;

		$monthes = array(
			1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
			5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
			9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
		);
		$date_start = date("d", strtotime($date_start)).' '.$monthes[(date("n", strtotime($date_start)))].' в '.date("H:i", strtotime($date_start));

		$price_fond = $tournament->pricefond;
		$maps = explode(',',$tournament->maps);
		$date_reg = date("d.m.Y", strtotime($tournament->datestart));
		$src = '/tournaments/'.$tournament->id.'/zayavka';
		
		$model = [
			'members' => $members,
			'datestart' => $date_start,
			'name' => $name,
			'pricefond' => $price_fond,
			'maps' => $maps,
			'datereg' => $date_reg,
			'src' => $src,
		];
		
        return $this->render('turnir', array('model'=>$model));
    }
	
	public function actionZayavka($id, $action)
    {
		$check = Tournament::find()->where(['status'=>10])->all();
		foreach($check as $key => $value){
			if(date("Y-m-d", strtotime($value->dateend)) < date("Y-m-d")){
				$change = Tournament::findOne($value->id);
				$change->status = 0;
				$change->update();
			}
		}
		$tournament = Tournament::findOne($id);
		if ($tournament === null || date("Y-m-d", strtotime($tournament->dateend)) < date("Y-m-d"))
            return Yii::$app->response->redirect(['/404']);
		
		$name = $tournament->name; //имя
		$members = ($tournament->members);

		$date_start = $tournament->datestart;

		$monthes = array(
			1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
			5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
			9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
		);
		$date_start = date("d", strtotime($date_start)).' '.$monthes[(date("n", strtotime($date_start)))].' в '.date("H:i", strtotime($date_start));
		
		$date_for_calc = $tournament->dateend;
		
		
		$price = 0;
		$price_fond = $tournament->pricefond;
		foreach (explode(',',$price_fond) as $key => $value){
			$price = $price+$value;
		}
		$src_back = '/tournaments/'.$id;
		$commands = Commands::find()->where('tournament='.$id)->all();
		if ($commands === null){
            $teams = Yii::t('Ещё не созданы');
		} else {
			$teams = $commands;
		}
		
		$model = [
			'members' => $members,
			'datestart' => $date_start,
			'dateforcalc' => $date_for_calc,
			'name' => $name,
			'pricefond' => $price,
			'srcback' => $src_back,
			'teams' => $teams,
		];
		
		
        return $this->render('zayavka', array('model'=>$model));
    }
	
	public function actionTeam($id, $team)
    {
		$check = Tournament::find()->where(['status'=>10])->all();
		foreach($check as $key => $value){
			if(date("Y-m-d", strtotime($value->dateend)) < date("Y-m-d")){
				$change = Tournament::findOne($value->id);
				$change->status = 0;
				$change->update();
			}
		}
		$tournament = Tournament::findOne($id);
		if ($tournament === null || date("Y-m-d", strtotime($tournament->dateend)) < date("Y-m-d"))
            return Yii::$app->response->redirect(['/404']);
		
		$name = $tournament->name; //имя
		$members = ($tournament->members);

		$date_start = $tournament->datestart;

		$monthes = array(
			1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
			5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
			9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
		);
		$date_start = date("d", strtotime($date_start)).' '.$monthes[(date("n", strtotime($date_start)))].' в '.date("H:i", strtotime($date_start));
		
		$date_for_calc = $tournament->dateend;
		
		
		$price = 0;
		$price_fond = $tournament->pricefond;
		foreach (explode(',',$price_fond) as $key => $value){
			$price = $price+$value;
		}
		$src_back = '/tournaments/'.$id;
		$commands = $team;
		if ($commands === null){
            $teams = Yii::t('Ещё не созданы');
		} else {
			$teams = $commands;
		}
		
		$model = [
			'members' => $members,
			'datestart' => $date_start,
			'dateforcalc' => $date_for_calc,
			'name' => $name,
			'pricefond' => $price,
			'srcback' => $src_back,
			'teams' => $teams,
		];
		
		
        return $this->render('team', array('model'=>$model));
    }
	
	public function actionTeamecreate($id)
    {
		if(Yii::$app->user->isGuest){
			return Yii::$app->response->redirect(['/login']);
		}
		$tournament = Tournament::findOne($id);
		if ($tournament === null)
            return Yii::$app->response->redirect(['/404']);
		
		$name = $tournament->name; //имя
		$members = ($tournament->members);

		$date_start = $tournament->datestart;

		$monthes = array(
			1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
			5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
			9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
		);
		$date_start = date("d", strtotime($date_start)).' '.$monthes[(date("n", strtotime($date_start)))].' в '.date("H:i", strtotime($date_start));
		
		$date_for_calc = $tournament->dateend;
		
		
		$price = 0;
		$price_fond = $tournament->pricefond;
		foreach (explode(',',$price_fond) as $key => $value){
			$price = $price+$value;
		}
		$src_back = '/tournaments/'.$id;
		
		$model = [
			'tournament_id' => $tournament->id,
			'members' => $members,
			'datestart' => $date_start,
			'dateforcalc' => $date_for_calc,
			'name' => $name,
			'pricefond' => $price,
			'srcback' => $src_back,
		];
		
		$form_model = new Commands();
		if(isset($_POST['Commands']['name']) && isset($_POST['Commands']['description']) && isset($_POST['Commands']['password'])){
			$form_model->name = $_POST['Commands']['name'];
			$form_model->description = $_POST['Commands']['description'];
			$form_model->password = $_POST['Commands']['password'];
			$form_model->capitan = $_POST['Commands']['capitan'];
			$form_model->tournament = $_POST['Commands']['tournament'];
			if($form_model->save()){
				$changecapitan = User::findOne($_POST['Commands']['capitan']);
				$changecapitan->command = $form_model->id;
				$changecapitan->save();
				return Yii::$app->response->redirect(['/tournaments/'.$id]);
			}
		}
		
		return $this->render('teamecreate', ['model'=>$model, 'form_model' => $form_model]);
	}
	
}