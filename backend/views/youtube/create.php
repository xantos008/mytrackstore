<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Youtube */

$this->title = Yii::t('app', 'Создать ссылку');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Видео'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="youtube-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
