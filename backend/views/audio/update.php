<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Audio */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Audio',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<style>
	.sudapadat, .shes, .inline.formg-roup{
		display: none !important;
	}
</style>
<div class="audio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
