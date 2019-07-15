<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use common\models\User;


use frontend\models\PasswordChangeForm;

class ProfileController extends \yii\web\Controller
{
	
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
	
	private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }
	
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }
	
	
	public function actionPassword()
    {
        $user = $this->findModel();
        $model = new PasswordChangeForm($user);
 
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('password', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUpdateEmail()
    {
        $model = $this->findModel();
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update-email', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionLink()
    {
        $model = $this->findModel();
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('link', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionPremium()
    {
        $model = $this->findModel();
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('premium', [
                'model' => $model,
            ]);
        }
    }
	
}
