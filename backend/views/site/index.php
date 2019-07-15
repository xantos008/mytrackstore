<?php

/* @var $this yii\web\View */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

use common\models\Downloads;
use common\models\Djs;

$djs = Djs::find(['<>','id', 0])->all();

AppAsset::register($this);
$this->title = 'Административная панель';
?>
				<div class="now-status">
					<div class="ramka">
						<div class="stat-head">
							<p>Текущее состояние сайта</p>
						</div>
						<div class="stat-info col-md-6">
							<table>
								<tr>
									<td class="stat-left">На сайте:</td>
									<td class="stat-right"><?php echo $model['online_users'];?> человек</td>
								</tr>
								<tr>
									<td class="stat-left">Пользователей:</td>
									<td class="stat-right"><?php echo $model['all_users']; ?> человек</td>
								</tr>
								<tr>
									<td class="stat-left">Пользователи с премиум:</td>
									<td class="stat-right"><?php echo $model['users_premium']; ?> человек</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				
				<div class="now-status">
					<div class="ramka">
						<div class="stat-head">
							<p>Статистика по диджеям</p>
						</div>
						<div class="stata">
							<form action="" method="POST" id="statistics">
								
								<div class="form-controls">
									<p style="color:#fff">Выберите диджея</p>
									<select name="djcode">
										<?php
											foreach($djs as $key=>$value){
												echo '<option value="'.$value->id.'">'.$value->name.'</option>';
											}
										?>
									</select>
								</div>
								<div class="form-controls">
									<div class="inline">
										<p>Дата начала</p>
										<input type="date" name="before" placeholder="Дата начала(дд.мм.гггг)">
									</div>
									<div class="inline">
										<p>Дата конца</p>
										<input type="date" name="after" placeholder="Дата конца(дд.мм.гггг)">
									</div>
									<div class="inline">
										<button type="submit" class="btn btn-success">Отправить</button>
									</div>
								</div>
								
								<?php
									if(isset($_POST)){
										if(isset($_POST['djcode']) && isset($_POST['before']) && isset($_POST['after'])){
											
											$dj = Djs::findOne($_POST['djcode']);
											$djname = $dj->name;
											
											$date1 = date("Y-m-d H:i:s", strtotime($_POST['before']));
											$date2 = date("Y-m-d H:i:s", strtotime($_POST['after']));
											$downloads = Downloads::find()->where(['dj_id'=> $_POST['djcode']])->all();
											
											$n=0;
											foreach($downloads as $k=>$v){
												if($v->date >= $date1 && $v->date <= $date2){
													$n++;
												}
											}
											
											?>
												<div class="djinfo">
													<div class="inline">
														<p style="color: green;">У диджея <?php echo $djname;?>: <?php echo $n;?> скачанных трека за период <?php echo $_POST['before'].' - '.$_POST['after'];?></p>
													</div>
												</div>
											<?php
										}
									}
								?>
								
							</form>
						</div>
					</div>
				</div>
