<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model app\models\Pages */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Страницы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

				<div class="pages-view">

					<div class="inline">
					<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) 
					?>	
					</div>

					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							'id',
							'title',
							'alias',
							'published',
							'content:ntext',
							'header_position',
							'type',
							'file',
							'title_browser',
							'meta_keywords',
							'meta_description',
							'created_at',
							'updated_at',
						],
					]) ?>

				</div>
					<div class="inline">
						<?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary', 'style'=>'padding: 14px 45px 16px;']) ?>
					</div>
					<div class="inline">
						<?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
							'class' => 'btn btn-danger btn-primary',
							'data' => [
								'confirm' => Yii::t('app', 'Вы уверены?'),
								'method' => 'post',
							],
						]) ?>
					</div>
					