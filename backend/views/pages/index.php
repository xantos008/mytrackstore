<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php

/* @var $this yii\web\View */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Страницы');
$this->params['breadcrumbs'][] = $this->title;
?>

				<div class="pages-index">
					<div class="inline">
					<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) 
					?>	
					</div>
					<div class="inline right">
						<?= Html::a(Yii::t('app', 'Создать страницу'), ['create'], ['class' => 'btn btn-success btn-primary']) ?>
					</div>
					<?php Pjax::begin(); ?>    
					
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'filterModel' => $searchModel,
							'columns' => [
								//['class' => 'yii\grid\SerialColumn'],

								//'id',
								[
									'header' => '№',
									'value' => 'id'
								],
								[
									'header' => 'Название страницы',
									'value' => 'title'
								],
								[
									'header' => 'Просмотреть',
									'value' => function ($data) {
										return '<a href="/page/?page='.$data->alias.'">Перейти</a>';
									},
									'format' => 'raw',
								],
								[
									'header' => 'Просмотреть',
									'value' => function ($data) {
										return '<div class="inlinetd"><a class="block" href="/pages/update?id='.$data->id.'">Редакт.</a></div><div class="inlinetd"><img src="/img/arrow-down-b_icon-icons.png"><br><a class="absolute" href="delete?id='.$data->id.'">Удалить</a></div>';
									},
									'format' => 'raw',
								],
								
								//'alias',
								//'published',
								//'content:ntext',
								// 'header_position',
								// 'type',
								// 'file',
								// 'title_browser',
								// 'meta_keywords',
								// 'meta_description',
								// 'created_at',
								// 'updated_at',

								//['class' => 'yii\grid\ActionColumn'],
								
							],
						]); ?>
				<?php Pjax::end(); ?>
			</div>
		