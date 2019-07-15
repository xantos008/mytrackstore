<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Audio;
use common\models\AudioSearch;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

use common\models\User;
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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            //'error' => [
			//	'class' => 'yii\web\ErrorAction',
            //],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new AudioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
  
  	public function actionDownload()
    {
        return $this->render('download');
    }
	
  	public function actionMedia()
    {
        return $this->render('media');
    }
	
	public function actionUpsloan()
    {
        return $this->render('upsloan');
    }
    /**
     * Logs in a user.
     *
     * @return mixed
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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {		
        Yii::$app->user->logout();
		
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Спасибо за заявку, мы свяжемся с вами в ближайшее время.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка отправки сообщения.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
	
    /**
     * Displays about page.
     *
     * @return mixed
     */
	
	public function actionAbout()
    {
            return $this->render('about');
    }
	
	public function actionCompilation()
    {
		$this->layout = 'compilation';

		return $this->render('compilation');
    }
	
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
		$textbodey = Yii::t('app','Здравствуйте! Вы успешно зарегистрировались на сайте MyTrackStore.com. Осталось только подтвердить ваш электронный адрес. Для этого вбейте ссылку в адресной строке браузера:');
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
					if(isset($_POST)){
						if($_POST['SignupForm']['email'] && Yii::$app->user->identity->confirmemail == 0){
						$content23 = Yii::t('app','Здравствуйте! Вы успешно зарегистрировались на сайте MyTrackStore.com. <br><br> Осталось только подтвердить ваш электронный адрес. <br>Для этого пройдите по ссылке или вбейте ее в адресной страке браузера:').' <a target="_blank" href="http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'].'">http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'].'</a>';
						$send = Yii::$app->mailer->compose()
							->setFrom(['robot-search@mytrackstore.com' => 'Mytrackstore'])
							->setTo($_POST['SignupForm']['email'])
							->setSubject($_POST['SignupForm']['username'].', '.Yii::t('app', 'Вы зарегистрировались на сайте MyTrackStore.com'))
							->setTextBody($textbodey.' http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'])
							->setHtmlBody($content23)
							->send();
						}
					}
                    return $this->redirect(['/profile']);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'enableCsrfValidation'=> false,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
}
