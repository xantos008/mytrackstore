<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Categories;
use common\models\Djs;
/* @var $this yii\web\View */
/* @var $model common\models\Audio */
/* @var $form yii\widgets\ActiveForm */
$categories = [];
$cats = Categories::find()->all();
foreach($cats as $key=>$value){
	$categories[$value->id] = $value->name;
}
unset($cats);
$Djs = [];
$cats = Djs::find()->all();
foreach($cats as $key=>$value){
	$Djs[$value->id] = $value->name;
}
unset($cats);
?>
<style>
.shes1 {
    background: #fff;
    font-size: 20px;
	color: #000;
    width: 200px;
    text-align: center;
    padding: 4px 0 7px 0;
    margin: 10px 10px 30px 10px;
    border-radius: 5px;
    cursor: pointer;
}
.shes {
    background: #fff;
    font-size: 20px;
    width: 200px;
    text-align: center;
    padding: 4px 0 7px 0;
    margin: 10px 10px 30px 10px;
    border-radius: 5px;
    cursor: pointer;
}
.shes:hover {
    background: #555;
    color: #fff;
}
.fileform {
    background-color: transparent;
    border: none;
	color: #fff;
    border-radius: 2px;
    cursor: pointer;
    height: auto;
    overflow: hidden;
    padding: 2px;
    position: relative;
    text-align: left;
    vertical-align: middle;
    width: 230px;
}
</style>
<div class="audio-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'category')->dropDownList($categories)->label('Категория') ?>
    <?= $form->field($model, 'dj_id')->dropDownList($Djs)->label('Диджей') ?>
	<div class="inline formg-roup">
		<p>Загрузка трека</p>
	</div>
	<div class="sudapadat">
		<div class="itsparent">
			<div class="fileform">
				<input type="file" onchange="getName(this)" name="userfile[]" />
			</div>
			<div style="display:none">
				<?= $form->field($model, 'filename[]')->textInput(['type'=>'hidden'])->label('')->error(false) ?>

				<?= $form->field($model, 'path[]')->textInput(['type'=>'hidden'])->label('')->error(false) ?>

				<?= $form->field($model, 'views[]')->textInput(['value'=>0,'type'=>'hidden'])->label('')->error(false) ?>

				<?= $form->field($model, 'adddate[]')->textInput(['value'=>date('Y-m-d H:i:s'),'type'=>'hidden'])->label('')->error(false) ?>
			</div>
		</div>
	</div>
	
	<p class="shes" onlick="morema()">Добавить ещё</p>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			var html = $('.sudapadat').html();
			$('.shes').click(function(){
				$('.sudapadat').append(html);
			});
		});
		
		//function getName(e){
			
		//};
	</script>
	<script>
		//$(document).click(function(){
			function getName( e ){
				var files;
				if ($(e).val().lastIndexOf('\\')){
					var i = $(e).val().lastIndexOf('\\')+1;
				} else {
					var i = $(e).val().lastIndexOf('/')+1;
					}						
				var filename = $(e).val().slice(i);
				var parent = $(e).closest('.itsparent');
				$(parent).find('input[name="Audio[filename][]"]').val(filename);
				// Создадим данные формы и добавим в них данные файлов из files
				files = e.files;
				var data = new FormData();
				$.each( files, function( key, value ){
					data.append( key, value );
				});
				
				var obect = $(e);
				// Отправляем запрос
			 
				$.ajax({
					url: location+'?uploadfiles',
					type: 'POST',
					data: data,
					cache: false,
					dataType: 'json',
					processData: false, // Не обрабатываем файлы (Don't process the files)
					contentType: false, // Так jQuery скажет серверу что это строковой запрос
					success: function( respond, textStatus, jqXHR ){
						
						// Если все ОК
			 
						if( typeof respond.error === 'undefined' ){
							// Файлы успешно загружены, делаем что нибудь здесь
			 
							// выведем пути к загруженным файлам в блок '.ajax-respond'
			 
							var files_path = respond.files;
							var html = '';
							$.each( files_path, function( key, val ){ html += val; } );
							if($('#afterajaxtogettext').length > 0){
								$('#afterajaxtogettext').remove();
							}
							$('body').append('<div id="afterajaxtogettext">'+html+'</div>');
							var englname = $('#afterajaxtogettext').find('#newname').text();
							var rusname = $('#afterajaxtogettext').find('#name').text();
							console.log(englname);
							console.log(rusname);
							console.log(obect.closest('.fileform').closest('.itsparent').find('.field-audio-path').find('input').attr('value','/audio/'+englname));
							obect.closest('.fileform').html('<p class="shes1">'+rusname+'</p>');
							//obect.parent('.itsparent').find('input[name="Audio[path][]"]').attr('value','/audio/'+englname);
						}
						else{
							console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
						}
						
						
					},
					error: function( jqXHR, textStatus, errorThrown ){
						console.log('ОШИБКИ AJAX запроса: ' + textStatus );
					}
				});
			 
			};
		//});
		</script>
</div>
