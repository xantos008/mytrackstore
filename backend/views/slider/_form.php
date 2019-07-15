<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\widgets\ActiveForm */
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
<div class="slider-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'sliderposition')->textInput() ?>

	<div class="sudapadat">
		<div class="itsparent">
			<div class="fileform">
				<input type="file" onchange="getName(this)" name="userfile" />
			</div>
			<?= $form->field($model, 'link')->textInput(['maxlength' => true])->label('Ссылка') ?>
			<div style="display:none">
				<?= $form->field($model, 'sliderpath')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
	</div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Создать'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			var html = $('.sudapadat').html();
			$('.shes').click(function(){
				$('.sudapadat').append(html);
			});
		});
		function getName(e){
			if ($(e).val().lastIndexOf('\\')){
				var i = $(e).val().lastIndexOf('\\')+1;
			} else {
				var i = $(e).val().lastIndexOf('/')+1;
				}						
			var filename = $(e).val().slice(i);
			console.log('asdasd');
			var parent = $(e).closest('.itsparent');
			console.log(parent.attr('class'));
			$(parent).find('#slider-sliderpath').val('/slider/'+filename);
		};
	</script>
	<script>
		$(document).click(function(){
			var files;
			
			$('input[type=file]').change(function(){
				files = this.files;
			});
			$('input[type=file]').change(function( event ){
				event.stopPropagation(); // Остановка происходящего
				event.preventDefault();  // Полная остановка происходящего
				
				// Создадим данные формы и добавим в них данные файлов из files
			 
				var data = new FormData();
				$.each( files, function( key, value ){
					data.append( key, value );
				});
				var obect = $(this);
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
							obect.closest('.fileform').html('<p class="shes1">'+html+'</p>');
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
		});
		</script>
</div>
