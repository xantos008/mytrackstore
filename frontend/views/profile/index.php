<?php
/* @var $this yii\web\View */
/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\helpers\Html;
use yii\widgets\DetailView;

use frontend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\Profile;
use common\models\User;

$date1 = ''.date('Y-m-d H:i:s',strtotime('+30 days',strtotime(''.Yii::$app->user->identity->premiumdate.''))).'';
$date2 = ''.date('Y-m-d H:i:s').'';

$datetime1 = date_create($date1);
$datetime2 = date_create($date2);
$interval = date_diff($datetime1, $datetime2);

if($datetime1 < $datetime2){
	$customer = User::findOne(Yii::$app->user->identity->id);
	$customer->premium = 0;
	$customer->save();
}

function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '',  'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        ' '=> '-',
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}
if(isset($_GET['cropimage'])){
	
	function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo Yii::t('app', 'Некорректный формат файла');
		return;
    }
	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}
	if (!$h_o) $h_o = $w_o/($w_i/$h_i);
	if (!$w_o) $w_o = $h_o/($h_i/$w_i);
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2) {
		imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		$func($img_o,$file_output);
	}
	imagedestroy($img_o);
}

function crop($file_input, $file_output, $crop = 'square',$percent = false) {
	$pers = 'http://mytrackstore.com/uploads/'.explode('/',$file_input)[count(explode('/',$file_input))-1];
	$file_input = $pers;
	$file_output = realpath('../../').'/frontend/web/uploads/'.explode('/',$file_input)[count(explode('/',$file_input))-1];
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo Yii::t('app', 'Невозможно получить длину и ширину изображения');
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo Yii::t('app', 'Некорректный формат файла');
		return;
    }
	if ($crop == 'square') {
		$min = $w_i;
		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	if ($w_o < 0) $w_o += $w_i;
	    $w_o -= $x_o;
	   	if ($h_o < 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	if ($type == 2) {
		imagejpeg($img_o,$file_output,100);
		
	} else {
		$func = 'image'.$ext;
		$func($img_o,$file_output);
	}
	imagedestroy($img_o);
}

//startshit
	function prov($per){
		if (isset($per)) {
			$per = stripslashes($per);
			$per = htmlspecialchars($per);
			$per = addslashes($per);		 
		}
		return $per;
	}


	if(isset($_POST)){
		$filenew = time().rand(100,999).'.jpg';
		
		$x1 = prov($_POST['x1']);
		$x2 = prov($_POST['x2']);
		$y1 = prov($_POST['y1']);
		$y2 = prov($_POST['y2']);
		$img = prov($_POST['img']);
		$crop = prov($_POST['crop']);

		crop($img, $crop.$filenew, array($x1, $y1, $x2, $y2));	
		
		echo $filenew;

	}

	exit();
}
if( isset( $_GET['uploadfiles'] ) ){
	$data = array();
 
    $error = false;
    $files = array();
 
    $uploaddir = realpath('../../').'/frontend/web/uploads/'; // . - текущая папка где находится submit.php
 
    // Создадим папку если её нет
 
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    // переместим файлы из временной директории в указанную
    foreach( $_FILES as $file ){
		
		$newname = rus2translit($file['name']);		
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($newname) ) ){
			
			switch(strtolower($file['type'])){
				case 'image/jpeg':
					$image = imagecreatefromjpeg($uploaddir . basename($newname));
					break;
				case 'image/png':
					$image = imagecreatefrompng($uploaddir . basename($newname));
					break;
				case 'image/gif':
					$image = imagecreatefromgif($uploaddir . basename($newname));
					break;
				default:
					exit('Unsupported type: '.$uploaddir . basename($newname));
			}
			// Target dimensions
			$max_width = 230;
			$max_height = 230;

			// Get current dimensions
			$old_width  = imagesx($image);
			$old_height = imagesy($image);

			// Calculate the scaling we need to do to fit the image inside our frame
			$scale      = min($max_width/$old_width, $max_height/$old_height);

			// Get the new dimensions
			$new_width  = ceil($scale*$old_width);
			$new_height = ceil($scale*$old_height);
			
			// Create new empty image
			$new = imagecreatetruecolor($new_width, $new_height);

			// Resize old image into new
			imagecopyresampled($new, $image, 
				0, 0, 0, 0, 
				$new_width, $new_height, $old_width, $old_height);
			
			imagejpeg($new, $uploaddir . basename($newname));
			
            $files[] = $file['name'];
			$ups = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
			$ups->avatar = '/uploads/'.$newname;
			$ups->save();
        }
        else{
            $error = true;
        }
    }
 
    $data = $error ? array('error' => Yii::t('app', 'Ошибка загрузки файлов.')) : array('files' => $files );
 
    echo json_encode( $data );

	exit();
}


$this->title = Yii::t('app', Yii::$app->user->identity->username);
$this->params['breadcrumbs'][] = $this->title;

/*if(!empty(Yii::$app->user->identity->premiumdate)){
	$date1 = ''.date('Y-m-d H:i:s',strtotime(''.Yii::$app->user->identity->premiumdate.'')).'';
	$date2 = ''.date('Y-m-d H:i:s').'';

	$datetime1 = date_create($date1);
	$datetime2 = date_create($date2);
	
	if($datetime1 < $datetime2 && Yii::$app->user->identity->premium > 0 && !empty(Yii::$app->user->identity->premiumdate)){
		$is_premium = 0;
		$cur_user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
		$cur_user->premium = 0;
		$cur_user->premiumdate = '';
		$cur_user->premiumcheck = '';
		$cur_user->save();
	}

	if($datetime1 > $datetime2 && Yii::$app->user->identity->premium == 0 && !empty(Yii::$app->user->identity->premiumdate)){
		$is_premium = 0;
		$cur_user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
		$cur_user->premium = 0;
		$cur_user->premiumdate = '';
		$cur_user->premiumcheck = '';
		$cur_user->save();
	}
}*/

$is_premium = Yii::$app->user->identity->premium;

$fights = Yii::$app->user->identity->fights;
$looses = Yii::$app->user->identity->looses;
$victories = Yii::$app->user->identity->victories;
$avatar = Yii::$app->user->identity->avatar;

$money = Yii::$app->user->identity->money;
$gold = Yii::$app->user->identity->gold;

if($is_premium !== 0){
	$acc_type = '<span style="color:rgb(39, 255, 59)">'.Yii::t('app', 'Премиум').'</span>';
	$buy_premium = 'none';
} else {
	$acc_type = '<span style="color:rgb(255, 77, 102)">'.Yii::t('app', 'Базовый').'</span>';
	$buy_premium = 'block';
}
$users = User::find()->all();
$referal = 0;
foreach($users as $key => $value){
	if($value->referal == Yii::$app->user->identity->id){
		$referal++;
	}
}
$col_persov = 0;
$sum_bonus = $referal*5;

if(isset($_GET)){
	if(isset($_GET['checkWord'])){
		if(!empty($_GET['checkWord'])){
			if($_GET['checkWord'] == Yii::$app->user->identity->checkmailcode && Yii::$app->user->identity->confirmemail == 0){
				$varifa = User::findOne(Yii::$app->user->identity->id);
				$varifa->confirmemail = 1;
				$varifa->save();
				header("Refresh:0");
			}
		}
	}
}
$morya = Yii::t('app','Отправить письмо ещё раз');
$textbodey = Yii::t('app','Здравствуйте! Вы успешно зарегистрировались на сайте MyTrackStore.com. Осталось только подтвердить ваш электронный адрес. Для этого вбейте ссылку в адресной строке браузера:');
if(isset($_POST)){
	if(isset($_POST['email']) && isset($_POST['id']) && isset($_POST['checkmailcode'])){
		if(!empty($_POST['email']) && !empty($_POST['id']) && !empty($_POST['checkmailcode'])){
			$content23 = Yii::t('app','Здравствуйте! Вы успешно зарегистрировались на сайте MyTrackStore.com. <br><br> Осталось только подтвердить ваш электронный адрес. <br>Для этого пройдите по ссылке или вбейте ее в адресной страке браузера:').' <a target="_blank" href="http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['checkmailcode'].'">http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['checkmailcode'].'</a>';
			$send = Yii::$app->mailer->compose()
				->setFrom(['robot-search@mytrackstore.com' => 'Mytrackstore'])
				->setTo($_POST['email'])
				->setSubject(Yii::$app->user->identity->username.', '.Yii::t('app', 'Вы зарегистрировались на сайте MyTrackStore.com'))
				->setTextBody($textbodey.' http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['checkmailcode'])
				->setHtmlBody($content23)
				->send();
			$morya = Yii::t('app','Письмо было отправлено. Отправить ещё раз?');
		}
	}
}
?>

<div class="top_wrapper loginfo">
	<div class="container">
		<div class="ball1"></div>
		<div class="row">
			<?php if(Yii::$app->user->identity->confirmemail == 0){ ?>
				<div class="col-lg-12 backfoprofile">
					<div class="container">
						<form id="notAllowed" method="POST">
							<input type="hidden" name="email" value="<?php echo Yii::$app->user->identity->email; ?>">
							<input type="hidden" name="id" value="<?php echo Yii::$app->user->identity->id; ?>">
							<input type="hidden" name="checkmailcode" value="<?php echo Yii::$app->user->identity->checkmailcode; ?>">
							<p style="color: #fff;margin: 0 auto;font-size: 18px;padding: 30px 30px 30px 0;"><?php echo Yii::t('app','Вы не подтвердили адрес вашей электронной почты. Пожалуйста, зайдите в ваш электронный ящик и перейдите по ссылке в письме. Если вам не пришло письмо с ссылкой, то пожалуйста нажмите на кнопку ниже');?></p>
							<button class="button-cart aee2 inline" id="sendMailAgain"><?php echo $morya; ?></button>
						</form>
					</div>
				</div>
			<?php } else {?>
				<div class="col-lg-12 backfoprofile">
					<div class="profile-ava-block">
					<?php if($avatar !== '' && !empty($avatar)){ ?>
						<div class="inline avka">
							<img src="<?php echo $avatar;?>" id="target" class="avatar-profile"><br>
							<button id="crop"><?=Yii::t('app', 'Обрезать')?></button>
							<p class="descpercrop"><?=Yii::t('app', 'Чтобы обрезать фото, нужно сразу выделить область на фото и нажать кнопку "Обрезать". Также Вы можете загрузить новое фото нажам на кнопку ниже "Загрузить".')?></p>
							<label id="puherename" for="downloadpic"><?=Yii::t('app', 'Загрузить')?></label>
							<input id="downloadpic" type="file" onchange="getName(this)" name="userfile[]">
							<div class="inline-labels" style="position:absolute;visibility:hidden;">
								<label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
								<label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
								<label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
								<label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
								<label>W <input type="text" size="4" id="w" name="w" /></label>
								<label>H <input type="text" size="4" id="h" name="h" /></label>
							</div>
							<div id="cropresult"></div>
						</div>
					<?php } else { ?>
						<div class="inline avka">
							<img src="/img/acc-face.png" class="avatar-profile"><br>
							<label id="puherename" for="downloadpic"><?=Yii::t('app', 'Загрузить')?></label>
							<input id="downloadpic" type="file" onchange="getName(this)" name="userfile[]">
						</div>
					<?php } ?>
				</div>
			<div class="containers">
				<div class="profile-left-info col-md-5">
					<h2 class="intitle"><?= Html::encode($this->title) ?></h2>
					<p class="datereg"><?=Yii::t('app', 'Дата регистрации')?>: <?php echo date('m.d.Y', Yii::$app->user->identity->created_at); ?></p>
					<p class="datereg"><?=Yii::t('app', 'Тип акканута')?>: <?=$acc_type?></p>
					<?php if($is_premium !== 0){ 
						$date1 = ''.date('Y-m-d H:i:s',strtotime('+30 days',strtotime(''.Yii::$app->user->identity->premiumdate.''))).'';
						$date2 = ''.date('Y-m-d H:i:s').'';

						$datetime1 = date_create($date1);
						$datetime2 = date_create($date2);
						$interval = date_diff($datetime1, $datetime2);
					?>
					<p class="datereg"><?=Yii::t('app', 'Осталось треков для скачивания')?>: <?php echo Yii::$app->user->identity->premium; ?></p>
					<p class="datereg"><?=Yii::t('app', 'Осталось дней премиум пользования')?>: <?php echo $interval->format('%a'); ?></p>
					<?php } ?>
					
					<div class="invites">
						<div class="inline">
							<p style="font-size:18px;padding: 20px 0;"><?=Yii::t('app', 'Поделиться в соц. сетях')?>:</p>
							<div class="social-networks">
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2Fmytrackstore.com" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://twitter.com/intent/tweet/?text=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>&amp;url=http%3A%2F%2Fmytrackstore.com" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://plus.google.com/share?url=http%3A%2F%2Fmytrackstore.com" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--google resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.37 12.93c-.73-.52-1.4-1.27-1.4-1.5 0-.43.03-.63.98-1.37 1.23-.97 1.9-2.23 1.9-3.57 0-1.22-.36-2.3-1-3.05h.5c.1 0 .2-.04.28-.1l1.36-.98c.16-.12.23-.34.17-.54-.07-.2-.25-.33-.46-.33H7.6c-.66 0-1.34.12-2 .35-2.23.76-3.78 2.66-3.78 4.6 0 2.76 2.13 4.85 5 4.9-.07.23-.1.45-.1.66 0 .43.1.83.33 1.22h-.08c-2.72 0-5.17 1.34-6.1 3.32-.25.52-.37 1.04-.37 1.56 0 .5.13.98.38 1.44.6 1.04 1.84 1.86 3.55 2.28.87.23 1.82.34 2.8.34.88 0 1.7-.1 2.5-.34 2.4-.7 3.97-2.48 3.97-4.54 0-1.97-.63-3.15-2.33-4.35zm-7.7 4.5c0-1.42 1.8-2.68 3.9-2.68h.05c.45 0 .9.07 1.3.2l.42.28c.96.66 1.6 1.1 1.77 1.8.05.16.07.33.07.5 0 1.8-1.33 2.7-3.96 2.7-1.98 0-3.54-1.23-3.54-2.8zM5.54 3.9c.33-.38.75-.58 1.23-.58h.05c1.35.05 2.64 1.55 2.88 3.35.14 1.02-.08 1.97-.6 2.55-.32.37-.74.56-1.23.56h-.03c-1.32-.04-2.63-1.6-2.87-3.4-.13-1 .08-1.92.58-2.5zM23.5 9.5h-3v-3h-2v3h-3v2h3v3h2v-3h3"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://www.tumblr.com/widgets/share/tool?posttype=link&amp;title=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>&amp;caption=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>&amp;content=http%3A%2F%2Fmytrackstore.com&amp;canonicalUrl=http%3A%2F%2Fmytrackstore.com&amp;shareSource=tumblr_share_button" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--tumblr resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13.5.5v5h5v4h-5V15c0 5 3.5 4.4 6 2.8v4.4c-6.7 3.2-12 0-12-4.2V9.5h-3V6.7c1-.3 2.2-.7 3-1.3.5-.5 1-1.2 1.4-2 .3-.7.6-1.7.7-3h3.8z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="mailto:?subject=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>&amp;body=http%3A%2F%2Fmytrackstore.com" target="_self" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--email resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 4H2C.9 4 0 4.9 0 6v12c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM7.25 14.43l-3.5 2c-.08.05-.17.07-.25.07-.17 0-.34-.1-.43-.25-.14-.24-.06-.55.18-.68l3.5-2c.24-.14.55-.06.68.18.14.24.06.55-.18.68zm4.75.07c-.1 0-.2-.03-.27-.08l-8.5-5.5c-.23-.15-.3-.46-.15-.7.15-.22.46-.3.7-.14L12 13.4l8.23-5.32c.23-.15.54-.08.7.15.14.23.07.54-.16.7l-8.5 5.5c-.08.04-.17.07-.27.07zm8.93 1.75c-.1.16-.26.25-.43.25-.08 0-.17-.02-.25-.07l-3.5-2c-.24-.13-.32-.44-.18-.68s.44-.32.68-.18l3.5 2c.24.13.32.44.18.68z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://pinterest.com/pin/create/button/?url=http%3A%2F%2Fmytrackstore.com&amp;media=http%3A%2F%2Fmytrackstore.com&amp;description=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--pinterest resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.14.5C5.86.5 2.7 5 2.7 8.75c0 2.27.86 4.3 2.7 5.05.3.12.57 0 .66-.33l.27-1.06c.1-.32.06-.44-.2-.73-.52-.62-.86-1.44-.86-2.6 0-3.33 2.5-6.32 6.5-6.32 3.55 0 5.5 2.17 5.5 5.07 0 3.8-1.7 7.02-4.2 7.02-1.37 0-2.4-1.14-2.07-2.54.4-1.68 1.16-3.48 1.16-4.7 0-1.07-.58-1.98-1.78-1.98-1.4 0-2.55 1.47-2.55 3.42 0 1.25.43 2.1.43 2.1l-1.7 7.2c-.5 2.13-.08 4.75-.04 5 .02.17.22.2.3.1.14-.18 1.82-2.26 2.4-4.33.16-.58.93-3.63.93-3.63.45.88 1.8 1.65 3.22 1.65 4.25 0 7.13-3.87 7.13-9.05C20.5 4.15 17.18.5 12.14.5z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=http%3A%2F%2Fmytrackstore.com&amp;title=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>&amp;summary=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>&amp;source=http%3A%2F%2Fmytrackstore.com" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--linkedin resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.5 21.5h-5v-13h5v13zM4 6.5C2.5 6.5 1.5 5.3 1.5 4s1-2.4 2.5-2.4c1.6 0 2.5 1 2.6 2.5 0 1.4-1 2.5-2.6 2.5zm11.5 6c-1 0-2 1-2 2v7h-5v-13h5V10s1.6-1.5 4-1.5c3 0 5 2.2 5 6.3v6.7h-5v-7c0-1-1-2-2-2z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://reddit.com/submit/?url=http%3A%2F%2Fmytrackstore.com" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--reddit resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M24 11.5c0-1.65-1.35-3-3-3-.96 0-1.86.48-2.42 1.24-1.64-1-3.75-1.64-6.07-1.72.08-1.1.4-3.05 1.52-3.7.72-.4 1.73-.24 3 .5C17.2 6.3 18.46 7.5 20 7.5c1.65 0 3-1.35 3-3s-1.35-3-3-3c-1.38 0-2.54.94-2.88 2.22-1.43-.72-2.64-.8-3.6-.25-1.64.94-1.95 3.47-2 4.55-2.33.08-4.45.7-6.1 1.72C4.86 8.98 3.96 8.5 3 8.5c-1.65 0-3 1.35-3 3 0 1.32.84 2.44 2.05 2.84-.03.22-.05.44-.05.66 0 3.86 4.5 7 10 7s10-3.14 10-7c0-.22-.02-.44-.05-.66 1.2-.4 2.05-1.54 2.05-2.84zM2.3 13.37C1.5 13.07 1 12.35 1 11.5c0-1.1.9-2 2-2 .64 0 1.22.32 1.6.82-1.1.85-1.92 1.9-2.3 3.05zm3.7.13c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm9.8 4.8c-1.08.63-2.42.96-3.8.96-1.4 0-2.74-.34-3.8-.95-.24-.13-.32-.44-.2-.68.15-.24.46-.32.7-.18 1.83 1.06 4.76 1.06 6.6 0 .23-.13.53-.05.67.2.14.23.06.54-.18.67zm.2-2.8c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm5.7-2.13c-.38-1.16-1.2-2.2-2.3-3.05.38-.5.97-.82 1.6-.82 1.1 0 2 .9 2 2 0 .84-.53 1.57-1.3 1.87z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://www.xing.com/app/user?op=share;url=http%3A%2F%2Fmytrackstore.com;title=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--xing resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.2 9.7l-3-5.4C7.2 4 7 4 6.8 4h-5c-.3 0-.4 0-.5.2v.5L4 10 .4 16v.5c0 .2.2.3.4.3h5c.3 0 .4 0 .5-.2l4-6.6v-.5zM24 .2l-.5-.2H18s-.2 0-.3.3l-8 14v.4l5.2 9c0 .2 0 .3.3.3h5.4s.3 0 .4-.2c.2-.2.2-.4 0-.5l-5-8.8L24 .7V.2z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="whatsapp://send?text=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>%20http%3A%2F%2Fmytrackstore.com" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.1 3.9C17.9 1.7 15 .5 12 .5 5.8.5.7 5.6.7 11.9c0 2 .5 3.9 1.5 5.6L.6 23.4l6-1.6c1.6.9 3.5 1.3 5.4 1.3 6.3 0 11.4-5.1 11.4-11.4-.1-2.8-1.2-5.7-3.3-7.8zM12 21.4c-1.7 0-3.3-.5-4.8-1.3l-.4-.2-3.5 1 1-3.4L4 17c-1-1.5-1.4-3.2-1.4-5.1 0-5.2 4.2-9.4 9.4-9.4 2.5 0 4.9 1 6.7 2.8 1.8 1.8 2.8 4.2 2.8 6.7-.1 5.2-4.3 9.4-9.5 9.4zm5.1-7.1c-.3-.1-1.7-.9-1.9-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1s-1.2-.5-2.3-1.4c-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6s.3-.3.4-.5c.2-.1.3-.3.4-.5.1-.2 0-.4 0-.5C10 9 9.3 7.6 9 7c-.1-.4-.4-.3-.5-.3h-.6s-.4.1-.7.3c-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.3-.3-.4-.6-.5z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://news.ycombinator.com/submitlink?u=http%3A%2F%2Fmytrackstore.com&amp;t=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--hackernews resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 140"><path fill-rule="evenodd" d="M60.94 82.314L17 0h20.08l25.85 52.093c.397.927.86 1.888 1.39 2.883.53.994.995 2.02 1.393 3.08.265.4.463.764.596 1.095.13.334.262.63.395.898.662 1.325 1.26 2.618 1.79 3.877.53 1.26.993 2.42 1.39 3.48 1.06-2.254 2.22-4.673 3.48-7.258 1.26-2.585 2.552-5.27 3.877-8.052L103.49 0h18.69L77.84 83.308v53.087h-16.9v-54.08z"></path></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="http://vk.com/share.php?title=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>&amp;url=http%3A%2F%2Fmytrackstore.com" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--vk resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.547 7h-3.29a.743.743 0 0 0-.655.392s-1.312 2.416-1.734 3.23C14.734 12.813 14 12.126 14 11.11V7.603A1.104 1.104 0 0 0 12.896 6.5h-2.474a1.982 1.982 0 0 0-1.75.813s1.255-.204 1.255 1.49c0 .42.022 1.626.04 2.64a.73.73 0 0 1-1.272.503 21.54 21.54 0 0 1-2.498-4.543.693.693 0 0 0-.63-.403h-2.99a.508.508 0 0 0-.48.685C3.005 10.175 6.918 18 11.38 18h1.878a.742.742 0 0 0 .742-.742v-1.135a.73.73 0 0 1 1.23-.53l2.247 2.112a1.09 1.09 0 0 0 .746.295h2.953c1.424 0 1.424-.988.647-1.753-.546-.538-2.518-2.617-2.518-2.617a1.02 1.02 0 0 1-.078-1.323c.637-.84 1.68-2.212 2.122-2.8.603-.804 1.697-2.507.197-2.507z"/></svg>
										</div>
									  </div>
									</a>
								</div>
								<div class="getline">
									<a class="resp-sharing-button__link" href="https://telegram.me/share/url?text=<?=Yii::t('app', 'Я%20уже%20зарегистрировался%20и%20скоро%20cмогу%20слушатm%20 и%20скачивать%20треки%20от%20DJ%20Graff!%20Присоединяйся%20и%20ты!')?>&amp;url=http%3A%2F%2Fmytrackstore.com" target="_blank" aria-label="">
									  <div class="resp-sharing-button resp-sharing-button--telegram resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
										  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M.707 8.475C.275 8.64 0 9.508 0 9.508s.284.867.718 1.03l5.09 1.897 1.986 6.38a1.102 1.102 0 0 0 1.75.527l2.96-2.41a.405.405 0 0 1 .494-.013l5.34 3.87a1.1 1.1 0 0 0 1.046.135 1.1 1.1 0 0 0 .682-.803l3.91-18.795A1.102 1.102 0 0 0 22.5.075L.706 8.475z"/></svg>
										</div>
									  </div>
									</a>
								</div>
							  </div>
						</div>
					</div>
					
					<div class="profile-changes">
						<?php if(Yii::$app->user->identity->stopemail == 0){?>
							<div class="button-cart aee2 inline stopemail">
								<a><p><?=Yii::t('app', 'Отписаться от рассылки')?></p></a>
							</div>
						<?php } else {?>
							<div class="button-cart aee2 inline startemail">
								<a><p><?=Yii::t('app', 'Подписаться на рассылку')?></p></a>
							</div>
						<?php } ?>
						<div class="button-cart aee2 inline deleteaccount">
							<a><p><?=Yii::t('app', 'Удалить аккаунт')?></p></a>
						</div>
						<div class="button-cart aee2 inline">
							<a href="/profile/password"><p><?=Yii::t('app', 'Изменить пароль')?></p></a>
						</div>
						<div class="button-cart aee2 inline">
							<a href="/profile/update-email"><p><?=Yii::t('app', 'Изменить электронную почту')?></p></a>
						</div>
						<div class="button-cart aee2 inline">
							<?php echo Html::beginForm(['/site/logout'], 'post')
								. Html::submitButton(
									'<a>'.Yii::t("app", "Выйти").'</a>',
									['class' => 'logout button-cart']
								)
								. Html::endForm(); ?>
						</div>
					</div>
					
				</div>
				<div class="profile-right-info col-md-4">
					<div class="ramka-offer" style="display:<?=$buy_premium?>">
							<div class="">
							  <p><?=Yii::t('app', 'На этой странице Вы можете совершить оплату подписки и получить доступ к странице с закрытым контентом. Стоимость составляет 635 рублей. После этого вы сможете в течении одного месяца скачивать любые треки на сайте (лимит 60 треков в месяц)')?></p><br>
							</div>
							<div class="" style="text-align: center;font-family: sans-serif;">
								
								<?php
								//Секретный ключ интернет-магазина premiumdate
								if($is_premium == 0){
								  if(empty(Yii::$app->user->identity->premiumcheck)){
									  $p_check = rand(1,99999)."-".rand(0,999);
									  $customer = User::findOne(Yii::$app->user->identity->id);
									  $customer->premiumcheck = $p_check ;
									  $customer->save();
								  } else {
									  $p_check = Yii::$app->user->identity->premiumcheck;
								  }
								  $key = "60535a31595579396b435f494c345342605e60695f567134545277";
								 
								  $fields = array();
								 
								  // Добавление полей формы в ассоциативный массив
								  $fields["WMI_MERCHANT_ID"]    = "174786962927";
								  $fields["WMI_PAYMENT_AMOUNT"] = "635.00";
								  $fields["WMI_CURRENCY_ID"]    = "643";
								  $fields["WMI_PAYMENT_NO"]     = $p_check;
								  $fields["WMI_DESCRIPTION"]    = "BASE64:".base64_encode("Приобрести премиум аккаунт");
								  $fields["WMI_SUCCESS_URL"]    = "http://mytrackstore.com/?id=".Yii::$app->user->identity->id."&progress=success";
								  $fields["WMI_FAIL_URL"]       = "http://mytrackstore.com/profile?paymentform=whatdoesitsaid2";

								  //Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
								  //$fields["WMI_PTENABLED"]      = array("UnistreamRUB", "SberbankRUB", "RussianPostRUB");
								 
								  //Сортировка значений внутри полей
								  foreach($fields as $name => $val)
								  {
									  if(is_array($val))
									  {
										  usort($val, "strcasecmp");
										  $fields[$name] = $val;
									  }
								  }
								 
								  // Формирование сообщения, путем объединения значений формы,
								  // отсортированных по именам ключей в порядке возрастания.
								  uksort($fields, "strcasecmp");
								  $fieldValues = "";
								 
								  foreach($fields as $value)
								  {
									  if(is_array($value))
										  foreach($value as $v)
										  {
											  //Конвертация из текущей кодировки (UTF-8)
											  //необходима только если кодировка магазина отлична от Windows-1251
											  $v = iconv("utf-8", "windows-1251", $v);
											  $fieldValues .= $v;
										  }
									  else
									  {
										  //Конвертация из текущей кодировки (UTF-8)
										  //необходима только если кодировка магазина отлична от Windows-1251
										  $value = iconv("utf-8", "windows-1251", $value);
										  $fieldValues .= $value;
									  }
								  }
								 
								  // Формирование значения параметра WMI_SIGNATURE, путем
								  // вычисления отпечатка, сформированного выше сообщения,
								  // по алгоритму MD5 и представление его в Base64
								 
								  $signature = base64_encode(pack("H*", md5($fieldValues . $key)));
								 
								  //Добавление параметра WMI_SIGNATURE в словарь параметров формы
								 
								  $fields["WMI_SIGNATURE"] = $signature;
								 
								  // Формирование HTML-кода платежной формы
								 
								  print "<form action='https://wl.walletone.com/checkout/checkout/Index' method='POST'>";
								 
								  foreach($fields as $key => $val)
								  {
									  if(is_array($val))
										  foreach($val as $value)
										  {
											  print "<input type='hidden' name='$key' value='$value'/>";
										  }
									  else
										  print "<input type='hidden' name='$key' value='$val'/>";
								  }
								 
								  print "<input type='submit' class='button-cart aee2 inline' value='".Yii::t('app', 'Приобрести премиум')."' /></form>";
								  print '<button class="button-cart aee2 inline" id="paymentsuccess">'.Yii::t("app", "Подтвердить оплату").'</button>';
								  ?>
								  <script>
									$('#paymentsuccess').click(function(){
										$.ajax({
											url: 'http://mytrackstore.com/site/upsloan',
											type: 'POST',
											data: {
												'createinvoice':'yes'
											},
											success: function( html ){
												$('body').prepend('<div class="modal" id="chlens"><div class="modal-body">'+html+'</div></div>');
												$('#chlens').fadeIn();
												setTimeout(function(){
													$('#chlens').fadeOut();
													//location.reload();
												},3000);
											},
										});
									});
								  </script>
								  <?php
								}
								?>
							</div>
							<div class="">
							  <p><?=Yii::t('app', 'После успешной оплаты, пожалуйста, нажмите на кнопку "Подтвердить оплату", чтобы мы все проверили. Для дополнительной информации можно связаться по контактому email')?>: <a class="mymail" href="mailto:djGraff2005@yandex.ru">djGraff2005@yandex.ru</a></p><br>
							</div>
					</div>
				</div>
			</div>
	 </div>
			<?php } ?>
  </div>
 </div>
<script type="text/javascript">
						function getName(e){
							if ($(e).val().lastIndexOf('\\')){
								var i = $(e).val().lastIndexOf('\\')+1;
							} else {
								var i = $(e).val().lastIndexOf('/')+1;
								}						
							var filename = $(e).val().slice(i);
							$('#puherename').html(filename);							
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
											$.each( files_path, function( key, val ){ html += val; } );
											location.reload();
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
<script src="js/jquery.Jcrop.min.js"></script>
<script src="js/crop.js"></script>
<script>
$(document).ready(function(){
	$('.stopemail').click(function(){
		$('#jacksays').fadeIn();
		$('#whatactiontodo').val('stopemail');
	});
	$('.deleteaccount').click(function(){
		$('#jacksays').fadeIn();
		$('#whatactiontodo').val('deleteaccount');
	});
	$('.startemail').click(function(){
		$('#jacksays').fadeIn();
		$('#whatactiontodo').val('startemail');
	});
	$('.close-all-modals').click(function(){
		console.log('adasdasdas');
		$('#jacksays').fadeOut();
	});
	$('.otmena-all-modals').click(function(){
		console.log('adasdasdas');
		$('#jacksays').fadeOut();
	});
	$('#so-on').submit(function(event){
		event.preventDefault();
		var data = $(this).serialize();
		$.ajax({
			url: "/site/upsloan",
			type: "post",
			data: data,
			success: function(data){
				if(data !== ''){
					$('#recaptchaError').html(data);
				}
			},
		});
	})
});
</script>
<div class="modal" id="jacksays">
	<div class="modal-content">
		<div class="close-all-modals">X</div>
		<form method="POST" id="so-on">
			<p id="zagswed"><?=Yii::t('app', 'Вы уверены?')?></p>
			<div class="buts">
				<div class="button-cart aee2 inline">
					<button type="submit" name="gunit"><p><?=Yii::t('app', 'Да')?></p></button>
				</div>
				<div class="button-cart aee2 inline otmena-all-modals">
					<a><p><?=Yii::t('app', 'Отмена')?></p></a>
				</div>
			</div>
			<input type="hidden" name="whatsnow" id="whatactiontodo">
			<div class="g-recaptcha" data-sitekey="6LdOwWYUAAAAAIgvwgkzPdhkfmhI2xiSj2vy-aOg"></div>
			<div class="text-danger" id="recaptchaError"></div>
		</form>
	</div>
</div>

<?php
/*unset($date1);
unset($date2);
unset($datetime1);
unset($datetime2);
unset($customer);
unset($string);
unset($converter);
unset($file_input);
unset($file_output);
unset($w_o);
unset($h_o);
unset($percent);
unset($type);
unset($w_i);
unset($h_i);
unset($types);
unset($ext);
unset($func);
unset($img);
unset($crop);
unset($min);
unset($x_o);
unset($y_o);
unset($img_o);
unset($per);
unset($filenew);
unset($x1);
unset($x2);
unset($y1);
unset($y2);
unset($data);
unset($error);
unset($files);
unset($uploaddir);
unset($_FILES);
unset($file);
unset($image);
unset($max_width);
unset($max_height);
unset($old_height);
unset($old_width);
unset($scale);
unset($new_height);
unset($new_width);
unset($new);
unset($newname);
unset($ups);
unset($is_premium);
unset($acc_type);
unset($buy_premium);
unset($avatar);
unset($users);
unset($key);
unset($value);
unset($referal);
unset($col_persov);
unset($sum_bonus);
unset($key);
unset($fields);
unset($name);
unset($val);
unset($fieldValues);
unset($v);
unset($signature);*/
?>