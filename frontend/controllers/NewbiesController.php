<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Newbies;
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
class NewbiesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
