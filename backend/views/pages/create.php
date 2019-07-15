<?php
/* @var $this yii\web\View */
/* @var $model app\models\Pages */
?>
<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('app', 'Создать страницу');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Страницы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if( isset( $_GET['uploadfiles'] ) ){
	$data = array();
 
    $error = false;
    $files = array();
 
    $uploaddir = realpath('../../').'/frontend/web/uploads/'; // . - текущая папка где находится submit.php
 
    // Создадим папку если её нет
 
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
 
    // переместим файлы из временной директории в указанную
    foreach( $_FILES as $file ){
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($file['name']) ) ){
            $files[] = realpath( $uploaddir . $file['name'] );
        }
        else{
            $error = true;
        }
    }
 
    $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('files' => $files );
 
    echo json_encode( $data );

	exit();
}

?>
				<div class="pages-create">

					<div class="inline">
					<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) 
					?>	
					</div>

					<?= $this->render('_form', [
						'model' => $model,
					]) ?>

				</div>
			</div>
