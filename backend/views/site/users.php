<?php

/* @var $this yii\web\View */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
$this->title = 'Административная панель';
?>

		<div class="row col-md-10">
			<div class="admin-row-head">
				<div class="admin-row-head-left"><img src="../img/gladiators-text.png"></div>
				<div class="admin-row-head-right"><p>Сегодня <?php echo date('d.m.Y h:m');?></p></div>
			</div>
			<div class="col-md-4">
				<div class="sidebar" id="sidebar-offten">
					<?php
					if(!Yii::$app->user->isGuest){
					$menuItems = [
						'<li><a href="/site/navigation/">Навигация</a></li>
						<li><a href="/">Главная страница</a></li>
						<li><a href="/pages/">Страницы</a></li>
						<li><a href="/users/">Пользователи</a></li>
						<li><a href="/admins/">Администраторы</a></li>'
					];

					echo Nav::widget([
						'options' => ['class' => 'nav nav-list'],
						'items' => $menuItems,
					]);
					}
					?>

						<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) 
					?>	
				</div>
				<div class="sidebar" id="sidebar">
					<?php
					if(!Yii::$app->user->isGuest){
					$menuItems = [
						['label' => 'Перейти на сайт', 'url' => ['/site/index']],
					];
					$menuItems[] = '<li>'
						. Html::beginForm(['/site/logout'], 'post')
						. Html::submitButton(
							'<a>Выйти</a>',
							['class' => 'logout']
						)
						. Html::endForm()
						. '</li>';
					echo Nav::widget([
						'options' => ['class' => 'nav nav-list'],
						'items' => $menuItems,
					]);
					}
					?>
					
						<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) 
					?>	
				</div>
			</div>
			<div class="content col-md-8">
				<div class="now-status">
					<div class="ramka">
						<div class="stat-head">
							<p>Текущее состояние сайта</p>
						</div>
						<div class="stat-info col-md-6">
							<table>
								<tr>
									<td class="stat-left">В игре:</td>
									<td class="stat-right"><?php echo $model['users_ingame']; ?> человек</td>
								</tr>
								<tr>
									<td class="stat-left">На сайте:</td>
									<td class="stat-right"><?php echo $model['online_users'];?> человек</td>
								</tr>
								<tr>
									<td class="stat-left">Пользователей:</td>
									<td class="stat-right"><?php echo $model['all_users']; ?> человек</td>
								</tr>
								<tr>
									<td class="stat-left">Премиум аккаунтов</td>
									<td class="stat-right"><?php echo $model['users_premium']; ?> шт</td>
								</tr>
								<tr>
									<td class="stat-left">Скачиваний игры:</td>
									<td class="stat-right"><?php echo $model['game_downloads']; ?> раз</td>
								</tr>
							</table>
						</div>
						<div class="stat-devider"><img src="../img/vertical-devider.png"></div>
						<div class="stat-info media-cal">
							<table>
								<tr>
									<td class="stat-left">Новостей:</td>
									<td class="stat-right"><?php echo $model['news_active']; ?> шт</td>
								</tr>
								<tr>
									<td class="stat-left">Акций(Акт):</td>
									<td class="stat-right"><?php echo $model['akcii_active']; ?> шт</td>
								</tr>
								<tr>
									<td class="stat-left">Турниров(Акт):</td>
									<td class="stat-right"><?php echo $model['tournaments_active']; ?> шт</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="now-status">
					<div class="ramka">
						<div class="stat-head">
							<p>Статистика за сегодня</p>
						</div>
						<div class="stat-info col-md-6">
							<table>
								<tr>
									<td class="stat-left">Пользователей:</td>
									<?php 
									if($model['users_plus'] > 0){
										echo '<td class="stat-right">+ '.$model['users_plus'].' человека</td>';
									} else {
										echo '<td class="stat-right">'.$model['users_plus'].'</td>';
									}
									?>
								</tr>
								<tr>
									<td class="stat-left">Премиум аккаунтов:</td>
									<?php 
									if($model['premium_buy_plus'] > 0){
										echo '<td class="stat-right">+ '.$model['premium_buy_plus'].' шт</td>';
									} else {
										echo '<td class="stat-right">'.$model['premium_buy_plus'].'</td>';
									}
									?>
								</tr>
								<tr>
									<td class="stat-left">Скачиваний игры:</td>
									<?php 
									if($model['game_downloads_plus'] > 0){
										echo '<td class="stat-right">+ '.$model['game_downloads_plus'].' раз</td>';
									} else {
										echo '<td class="stat-right">'.$model['game_downloads_plus'].'</td>';
									}
									?>
								</tr>
							</table>
						</div>
						<div class="stat-devider"><img src="../img/vertical-devider.png" height="180px"></div>
						<div class="stat-info media-cal">
							<table>
								<tr>
									<td class="stat-left">Новостей:</td>
									<?php 
									if($model['news_plus'] > 0){
										echo '<td class="stat-right">+ '.$model['news_plus'].' шт</td>';
									} else {
										echo '<td class="stat-right">'.$model['news_plus'].'</td>';
									}
									?>
									
								</tr>
								<tr>
									<td class="stat-left">Акций:</td>
									<?php 
									if($model['akcii_plus'] > 0){
										echo '<td class="stat-right">+ '.$model['akcii_plus'].' шт</td>';
									} else {
										echo '<td class="stat-right">'.$model['akcii_plus'].'</td>';
									}
									?>
								</tr>
								<tr>
									<td class="stat-left">Турниров:</td>
									<?php 
									if($model['tournament_plus'] > 0){
										echo '<td class="stat-right">+ '.$model['tournament_plus'].' шт</td>';
									} else {
										echo '<td class="stat-right">'.$model['tournament_plus'].'</td>';
									}
									?>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="now-status showoff">
					<div class="ramka">
						<div class="stat-info">
							<p>Статистика за:</p>
						</div>
						<form method="POST" action="">
							<div class="stat-devider"><input class="form-control" name="checkdate" type="date"></div>
							<div class="stat-info">
								<button type="submit" class="btn btn-primary">Посмотреть</button>
							</div>
						</form>
					</div>
						<?php if($model['plus'] == 'on'){?>
							<div class="stat-info col-md-6">
							<table>
								<tr>
									<td class="stat-left">Пользователей:</td>
									<?php 
									if($model['users_plus_more'] > 0){
										echo '<td class="stat-right">+ '.$model['users_plus_more'].' человека</td>';
									} else {
										echo '<td class="stat-right">'.$model['users_plus_more'].'</td>';
									}
									?>
								</tr>
								<tr>
									<td class="stat-left">Премиум аккаунтов:</td>
									<?php 
									if($model['premium_buy_plus_more'] > 0){
										echo '<td class="stat-right">+ '.$model['premium_buy_plus_more'].' шт</td>';
									} else {
										echo '<td class="stat-right">'.$model['premium_buy_plus_more'].'</td>';
									}
									?>
								</tr>
								<tr>
									<td class="stat-left">Скачиваний игры:</td>
									<?php 
									if($model['game_downloads_plus_more'] > 0){
										echo '<td class="stat-right">+ '.$model['game_downloads_plus_more'].' раз</td>';
									} else {
										echo '<td class="stat-right">'.$model['game_downloads_plus_more'].'</td>';
									}
									?>
								</tr>
							</table>
						</div>
						<div class="stat-devider"><img src="../img/vertical-devider.png" height="180px"></div>
						<div class="stat-info media-cal">
							<table>
								<tr>
									<td class="stat-left">Новостей:</td>
									<?php 
									if($model['news_plus_more'] > 0){
										echo '<td class="stat-right">+ '.$model['news_plus_more'].' шт</td>';
									} else {
										echo '<td class="stat-right">'.$model['news_plus_more'].'</td>';
									}
									?>
									
								</tr>
								<tr>
									<td class="stat-left">Акций:</td>
									<?php 
									if($model['akcii_plus_more'] > 0){
										echo '<td class="stat-right">+ '.$model['akcii_plus_more'].' шт</td>';
									} else {
										echo '<td class="stat-right">'.$model['akcii_plus_more'].'</td>';
									}
									?>
								</tr>
								<tr>
									<td class="stat-left">Турниров:</td>
									<?php 
									if($model['tournament_plus_more'] > 0){
										echo '<td class="stat-right">+ '.$model['tournament_plus_more'].' шт</td>';
									} else {
										echo '<td class="stat-right">'.$model['tournament_plus_more'].'</td>';
									}
									?>
								</tr>
							</table>
						</div>
						<?php } ?>
					
				</div>
			</div>
		</div>
