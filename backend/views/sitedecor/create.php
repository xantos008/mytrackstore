<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sitedecor */

$this->title = Yii::t('app', 'Создать задок');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sitedecors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if( isset( $_GET['uploadfiles'] ) ){
	$data = array();
 
    $error = false;
    $files = array();
 
    $uploaddir = realpath('../../').'/frontend/web/img/'; // . - текущая папка где находится submit.php
 
    // Создадим папку если её нет
 
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
 
    // переместим файлы из временной директории в указанную
    foreach( $_FILES as $file ){
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($file['name']) ) ){
            $files[] = $file['name'];
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
<div class="sitedecor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
