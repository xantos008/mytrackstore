<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<style>
table.table.table-striped.table-bordered tbody td {
    max-width: 150px;
    padding: 10px;
    word-break: break-all;
	overflow: hidden;
}
span.glyphicon.glyphicon-eye-open, span.glyphicon.glyphicon-pencil {
    display: none;
}

</style>
<div class="wrap">
    

    <div class="container">
<?php
if($_SERVER['REQUEST_URI'] !== '/site/login'){
?>
        <?= Alert::widget() ?>
		<div class="row col-md-10">
			<div class="admin-row-head">
				<div class="admin-row-head-left"><img src="/img/logo.png"></div>
				<div class="admin-row-head-right"><p>Сегодня <?php echo date('d.m.Y h:m');?></p></div>
			</div>
			<div class="col-md-4">
				<div class="sidebar" id="sidebar-offten">
					<?php
					if(!Yii::$app->user->isGuest){
					$menuItems = [
						['label' => 'Главная страница', 'url' => ['/site/index']],
						'<li><a href="/admin/audio/">Аудио</a></li>',
						'<li><a href="/admin/categories/">Категории</a></li>',
						'<li><a href="/admin/slider/">Слайдер</a></li>',
						'<li><a href="/admin/djs/">Диджеи</a></li>',
						'<li><a href="/admin/youtube/">Видео</a></li>',
						'<li><a href="/admin/compilation/">Сборник</a></li>',
						'<li><a href="/admin/sitedecor/">Сайт</a></li>',
						'<li><a href="/admin/sendmails">Отправить письма</a></li>',
					];

					echo Nav::widget([
						'options' => ['class' => 'nav nav-list'],
						'items' => $menuItems,
					]);
					}
					?>
	
				</div>
				<div class="sidebar" id="sidebar">
					<?php
					if(!Yii::$app->user->isGuest){
					$menuItems = [
						['label' => 'Перейти на сайт', 'url' => '/'],
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
				</div>
			</div>
			<div class="content col-md-8">
				<div class="user-index pages-index">
					<?= $content ?>
				</div>

			</div>
		</div>
<?php } else { ?>
		<?= Alert::widget() ?>
		<?= $content ?>
<?php } ?>
    </div>
</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
