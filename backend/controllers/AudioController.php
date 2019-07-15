<?php

namespace backend\controllers;

use Yii;
use common\models\Audio;
use common\models\AudioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class AudioController extends Controller
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
     * Lists all Audio models.
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

    /**
     * Displays a single Audio model.
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
     * Creates a new Audio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(isset($_POST)){
			if(!empty($_POST['Audio']['filename'][0])){
				for($i=0;$i<count($_POST['Audio']['filename']);$i++){
			
					$model = new Audio();
					
					$model->category = $_POST['Audio']['category'];
					$model->dj_id = $_POST['Audio']['dj_id'];
					$model->filename = $_POST['Audio']['filename'][$i];
					$model->path = $_POST['Audio']['path'][$i];
					$model->views = $_POST['Audio']['views'][$i];
					$model->adddate = $_POST['Audio']['adddate'][$i];
					
					$model->save();
				}
			}
		}
		$model = new Audio();
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //    return $this->redirect(['view', 'id' => $model->id]);
        //} else {
            return $this->render('create', [
                'model' => $model,
            ]);
        //}
    }

    /**
     * Updates an existing Audio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		if(isset($_POST)){
			if(isset($_POST['Audio'])){
				if(!empty($_POST['Audio'])){
					$update_track = Audio::findOne($id);
					$update_track->category = $_POST['Audio']['category'];
					$update_track->category = $_POST['Audio']['dj_id'];
					
					if($update_track->save()){
						return $this->redirect(['view', 'id' => $model->id]);
					} else {
						return $this->render('update', [
							'model' => $model,
						]);
					}
				}
			}
		}
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Audio model.
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
     * Finds the Audio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Audio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Audio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
