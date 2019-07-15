<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\models\Page;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'sendmails'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		function GetUsersOnline(){
			clearstatcache();
			$SessionDir = session_save_path();
			$Timeout = 60 * 3;
			if ($Handler = scandir ($SessionDir)){
				$count = count ($Handler);
				$users = 0;
				   
				for ($i = 2; $i < $count; $i++){
					if (time() - fileatime ($SessionDir . '/' . $Handler[$i]) < $Timeout){
						$users++;
					}
				}
									   
				return $users;
			} else {
				return 'error';
			}
		}
		
		$users = User::find()->where(['status' => 10])->all();
		$users_premium = User::find()->where(['<>', 'premium', 0])->all();
		$model['users_premium']=0;
		foreach($users_premium as $key=>$value){
			if(date('Y-m-d') < date('Y-m-d',strtotime('+30 days',strtotime($value->premiumdate))) . PHP_EOL){
				//echo $value->email.'<br>';
				$model['users_premium'] = $model['users_premium']+1;
			}
		}
		
		$users_ingame = User::find()->where(['!=', 'command', 0])->all();
		
		
		$model['online_users'] = number_format(GetUsersOnline(), 0, '', ' ');
		$model['all_users'] = number_format(count($users), 0, '', ' ');
		//$model['users_premium'] = number_format(count($users_premium), 0, '', ' ');
		$model['users_ingame'] = number_format(count($users_ingame), 0, '', ' ');

		
		$model['users_plus'] = 0;
		foreach($users as $key => $value){;
			if(date('Y-m-d') == date('Y-m-d', $value->created_at)){
				$model['users_plus'] = $model['users_plus']+1;
			}
		}
		
		$model['plus'] = 'off';
		
		return $this->render('index', [
                'model' => $model,
            ]);
    }
	
	public function actionSendmails()
    {
        return $this->render('sendmails');
    }
	
	public function actionCronstats()
    {
        return $this->render('cronstats');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	
	/**
     * Logout action.
     *
     * @return string
     */
    public function actionAkcii()
    {
		$model = Page::find()->where(['type'=>'akcii'])->all();
        return $this->render('akcii', [
                'model' => $model,
            ]);
    }
	
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
}
