<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\UserSearch;
use common\models\AuthAssignment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Blacklist;
$blacklist = Blacklist::find()->all();

$handle = @fopen(explode('backend',$_SERVER['DOCUMENT_ROOT'])[0].".htaccess", "w+");
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
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
		
		if(isset($_POST) && isset($_POST['User'])){
			$name = $_POST['User']['username'];
			$model->username = $_POST['User']['username'];
			$model->email = $_POST['User']['email'];
			$model->regip = $_POST['User']['regip'];
			$model->ifadminname = $_POST['User']['ifadminname'];
			$model->instagramm = $_POST['User']['instagramm'];
			$model->twitter = $_POST['User']['twitter'];
			$model->facebook = $_POST['User']['facebook'];
			$model->googleplus = $_POST['User']['googleplus'];
			$model->skype = $_POST['User']['skype'];
			$model->phone = $_POST['User']['phone'];
			$model->setPassword($_POST['User']['password']);
			$model->generateAuthKey();
		}
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$added = User::find()->where(['username' => $name])->one();
			
			$host = 'localhost';
			$database = 'gladiatorsbaseit';
			$user = 'gladiatorsbaseit2';
			$password = '123456789';
			$link = mysqli_connect($host, $user, $password, $database) 
				or die("Ошибка " . mysqli_error($link));
			 
			$query ="INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES ('admin', '".$added->id."', NULL)";
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
			
			if ($result) {
				return $this->redirect(['view', 'id' => $model->id]);
				mysqli_close($link);
			} else {
				return $this->render('create', [
					'model' => $model,
				]);
				mysqli_close($link);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
