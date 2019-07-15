<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\models\Charecter;
use common\models\AuthAssignment;
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
if(AuthAssignment::find()->where(['user_id'=>$model->id, 'item_name' => 'admin'])->one()){
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Администраторы'), 'url' => ['index?admin=1']];
	$whouser = 'admin';
} else {
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
	$whouser = 'user';
}
$this->params['breadcrumbs'][] = $this->title;
?>
				<div class="pages-create user-views">

					<div class="inline">
					<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) 
					?>	
					</div>
					<h1><?=$model->username?></h1>
					<?php if($whouser == 'admin'){ ?>
						<h2>Основная информация</h2>
						<table>
							<tr>
								<td>Статус:</td>
								<td><?php 
								if($model->isactive == 0){
									echo 'Оффлайн';
								} else {
									echo 'Онлайн';
								} ?></td>
							</tr>
							<tr>
								<td>Дата добавления:</td>
								<td><?php echo date('m.d.Y', $model->created_at); ?></td>
							</tr>
							<tr>
								<td>Имя администратора:</td>
								<td><?=$model->ifadminname?></td>
							</tr>
							<tr>
								<td>Ip адрес администратора:</td>
								<td><?=$model->regip?></td>
							</tr>
							<tr>
								<td>Последний визит администратора:</td>
								<td><?=date('m.d.Y', strtotime($model->lastdate))?></td>
							</tr>
						</table>
						<h2>Контактная информация</h2>
						<table>
						<p>Социальные сети</p>
							<tr>
								<td>Instagram:</td>
								<td><?=$model->instagramm?></td>
							</tr>
							<tr>
								<td>Twitter:</td>
								<td><?=$model->twitter?></td>
							</tr>
							<tr>
								<td>Facebook:</td>
								<td><?=$model->facebook?></td>
							</tr>
							<tr>
								<td>Google Plus:</td>
								<td><?=$model->googleplus?></td>
							</tr>
							<tr>
								<td>Skype:</td>
								<td><?=$model->skype?></td>
							</tr>
							<tr>
								<td>Телефон:</td>
								<td><?=$model->phone?></td>
							</tr>
						</table>
						<div style="text-align:center; padding: 30px 0 40px 0;">
							<?= Html::a(Yii::t('app', 'Удалить администратора'), ['delete', 'id' => $model->id], [
								'class' => 'btn btn-primary',
								'data' => [
									'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
									'method' => 'post',
								],
							]) ?>
						</div>
					<?php } else { ?>
						<p>Дата регистрации <?php echo date('m.d.Y', $model->created_at); ?></p>
						<h2>Основная информация</h2>
						<table>
							<tr>
								<td>Статус:</td>
								<td><?php 
								if($model->isactive == 0){
									echo 'Оффлайн';
								} else {
									echo 'Онлайн';
								} ?></td>
							</tr>
							<tr>
								<td>Email адрес:</td>
								<td><?=$model->email?></td>
							</tr>
							<tr>
								<td>Последний визит:</td>
								<td><?=date('m.d.Y', strtotime($model->lastdate))?></td>
							</tr>
							<tr>
								<td>Регистрационный ip адрес:</td>
								<td><?=$model->regip?></td>
							</tr>
							<tr>
								<td>Последний визит ip адрес:</td>
								<td><?=$model->lastip?></td>
							</tr>
						</table>
						<h2>Игровая информация</h2>
						<table>
							<tr>
								<td>Тип аккаунта:</td>
								<td><?php
									if($model->premium == 0){
										echo 'Базоый';
									} else {
										echo 'Премиум';
									}
								?></td>
							</tr>
							<tr>
								<td>Золото:</td>
								<td><?=$model->gold?></td>
							</tr>
							<tr>
								<td>Динарий:</td>
								<td><?=$model->money?></td>
							</tr>
							<tr>
								<td>Кол-во персонажей:</td>
								<td><?php
									$count = 0;
									$characters = Charecter::find()->where(['account_id'=>$model->id])->all();
									foreach($characters as $key=>$value){
										$count++;
									}
									echo $count;
								?></td>
							</tr>
							<tr>
								<td>Кол-во побед:</td>
								<td><?=$model->victories?></td>
							</tr>
							<tr>
								<td>Кол-во поражений:</td>
								<td><?=$model->looses?></td>
							</tr>
							<tr>
								<td>Кол-во боев:</td>
								<td><?=$model->fights?></td>
							</tr>
							<tr>
								<td>Личный рейтинг:</td>
								<td><?=$model->rate?></td>
							</tr>
						</table>
						<div style="text-align:center; padding: 30px 0 40px 0;">
							<?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
								'class' => 'btn btn-primary',
								'data' => [
									'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
									'method' => 'post',
								],
							]) ?>
						</div>
					<?php } ?>
				</div>
