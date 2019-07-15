<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\models\User;
use common\models\AuthAssignment;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if(isset($_GET['admin']) && $_GET['admin'] == 1){
	$this->title = Yii::t('app', 'Администраторы');
} else {
	$this->title = Yii::t('app', 'Пользователи');
}
$this->params['breadcrumbs'][] = $this->title;
?>
				<div class="user-index pages-index">
					<div class="inline">
					<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) 
					?>	
					</div>
					<div class="inline right">
						<?= Html::a(Yii::t('app', 'Создать администратора'), ['create'], ['class' => 'btn btn-success btn-primary']) ?>
					</div>
					<?php Pjax::begin(); ?>    
						<?php if(isset($_GET['admin']) && $_GET['admin'] == 1){?>
							<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'filterModel' => $searchModel,
							//'filterModel' => AuthAssignment::find()->where(['item_name'=>'admin'])->all(),
							'columns' => [
								//['class' => 'yii\grid\SerialColumn'],

								//'id',
								[
									'header' => 'ID',
									'value' => 'id'
								],
								[
									'header' => 'Лого',
									'value' => 'username',
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

								['class' => 'yii\grid\ActionColumn'],
								
							],
						]); ?>
						<?php } else { ?>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'filterModel' => $searchModel,
							'columns' => [
								//['class' => 'yii\grid\SerialColumn'],

								//'id',
								[
									'header' => 'ID',
									'value' => 'id'
								],
								[
									'header' => 'Лого',
									'value' => 'username'
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

								['class' => 'yii\grid\ActionColumn'],
								
							],
						]); }?>
				<?php Pjax::end(); ?>
			</div>
