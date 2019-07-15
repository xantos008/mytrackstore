<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название страницы')->error(false) ?>
	
    <?= $form->field($model, 'title_browser')->textInput(['maxlength' => true])->label('Meta title')->error(false) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true])->label('Meta keywords')->error(false) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true])->label('Meta description')->error(false) ?>
	
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true])->label('Символьный код')->error(false) ?>
	
	<?= $form->field($model, 'type')->dropDownList(['page' => 'page','news' => 'news','akcii'=>'akcii'])->label('Тип страницы')->error(false) ?>
	
    <?= $form->field($model, 'published')->textInput(['type'=>'hidden'])->label('')->error(false) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6])->label('Код страницы')->error(false) ?>

    <?= $form->field($model, 'header_position')->textInput(['type'=>'hidden'])->label('')->error(false) ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true, 'type'=>'hidden'])->label('')->error(false) ?>
	
	<div class="define-header-position">
		<div class="blocky" onclick="headerposition(this);">
			<p>1</p>
		</div>
		<div class="blocky" onclick="headerposition(this);">
			<p>2</p>
		</div>
		<div class="blocky" onclick="headerposition(this);">
			<p>3</p>
		</div>
		<div class="blocky" onclick="headerposition(this);">
			<p>4</p>
		</div>
	</div>
	
		<div class="checkboxes">
			<input type="checkbox" class="checkbox" id="shownews" />
			<label for="shownews">Отображать в ленте новостей?</label>
			<br>
			<input type="checkbox" class="checkbox" id="isactive" />
			<label for="isactive">Новость активна</label>
		</div>
	
		<div class="inline formg-roup">
				<p>Загрузка обложки</p>
		</div>
		<div class="fileform inline right">
			
			<div id="fileformlabel"></div>
			<div class="selectbutton">Обзор</div>
			<input id="upload" type="file" onchange="getName(this.value);" name="userfile" />
			<script>
				function getName (str){
					if (str.lastIndexOf('\\')){
						var i = str.lastIndexOf('\\')+1;
					}
					else{
						var i = str.lastIndexOf('/')+1;
					}						
					var filename = str.slice(i);			
					var uploaded = document.getElementById("fileformlabel");
					uploaded.innerHTML = filename;
				}
			</script>
			
			<script>
			var files;
			
			$('input[type=file]').change(function(){
				files = this.files;
			});
			$('#upload').change(function( event ){
				event.stopPropagation(); // Остановка происходящего
				event.preventDefault();  // Полная остановка происходящего
			 
				// Создадим данные формы и добавим в них данные файлов из files
			 
				var data = new FormData();
				$.each( files, function( key, value ){
					data.append( key, value );
				});
			 
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
							$.each( files_path, function( key, val ){ html += val; } )
							$('.ajax-respond').html( html );
							$('input[name="Pages[file]"]').val(html);
						}
						else{
							console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
						}
						
						
					},
					error: function( jqXHR, textStatus, errorThrown ){
						console.log('ОШИБКИ AJAX запроса: ' + textStatus );
					}
				});
			 
			});
			</script>
			<script>
				function headerposition(e){
					if($(e).hasClass('active')){
						$(e).removeClass('active');
					} else {
						$('.blocky').removeClass('active');
						$(e).addClass('active');
						var value = $(e).find('p').html();
						$('input[name="Pages[header_position]"]').attr('value', value);
					}
				}
				$( "label" ).click( function(){
					if($(this).hasClass('active')){
						$(this).removeClass('active');
						var value = $(this).attr('for');
						console.log(value);
						if(value == 'shownews'){
							$('select[name="Pages[type]"]').attr('value', 'page');
							$('select[name="Pages[type]"] option[value="page"]').attr('selected','');
						}
						if(value == 'isactive'){
							$('input[name="Pages[published]"]').attr('value', 0);
						}
					} else {
						$(this).addClass('active');
						var value = $(this).attr('for');
						console.log(value);
						if(value == 'shownews'){
							$('select[name="Pages[type]"]').attr('value', 'news');
							$('select[name="Pages[type]"] option[value="news"]').attr('selected','');
						}
						if(value == 'isactive'){
							$('input[name="Pages[published]"]').attr('value', 1);
						}
					}
				});
			</script>
		</div>


    <?= $form->field($model, 'created_at')->textInput(['type'=>'hidden'])->label('')->error(false) ?>

    <?= $form->field($model, 'updated_at')->textInput(['type'=>'hidden'])->label('')->error(false) ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать страницу') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success btn-primary' : 'btn btn-primary']) ?>
    </div>
	
    <?php ActiveForm::end(); ?>
	
</div>
