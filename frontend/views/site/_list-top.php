<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\components\MP3_Crop;
use falahati\PHPMP3\MpegAudio;

//bpm and initial_key

$PageEncoding = 'UTF-8';

require_once($_SERVER['DOCUMENT_ROOT'].'/common/components/getid3/getid3.php');


$getID3 = new getID3;
$getID3->setOption(array('encoding' => $PageEncoding));
$ss = $getID3->analyze($_SERVER['DOCUMENT_ROOT'].'/frontend/web'.$model->path);

$tone_n_bpm_string = '';

if(isset($ss['tags']['id3v2']['bpm'])){
	if(!empty($ss['tags']['id3v2']['bpm'])){
		$tone_n_bpm_string .= 'bpm: '.$ss['tags']['id3v2']['bpm'][0];
		$bpm = $ss['tags']['id3v2']['bpm'][0];
	} else {
		$tone_n_bpm_string = $tone_n_bpm_string;
		$bpm = '';
	}
} else {
	$tone_n_bpm_string = $tone_n_bpm_string;
	$bpm = '';
}

if(isset($ss['tags']['id3v2']['initial_key'])){
	if(!empty($ss['tags']['id3v2']['initial_key'])){
		if($tone_n_bpm_string == ''){
			$tone_n_bpm_string .= 'key: '.$ss['tags']['id3v2']['initial_key'][0];
			$tone = $ss['tags']['id3v2']['initial_key'][0];
		} else {
			$tone_n_bpm_string .= ', key: '.$ss['tags']['id3v2']['initial_key'][0];
			$tone = $ss['tags']['id3v2']['initial_key'][0];
		}
	} else {
		$tone_n_bpm_string = $tone_n_bpm_string;
		$tone = '';
	}
} else {
	$tone_n_bpm_string = $tone_n_bpm_string;
	$tone = '';
}

//end of bpm and initial key


$date1 = ''.$model->adddate.'';
$date2 = ''.date('Y-m-d H:i:s').'';

$datetime1 = date_create($date1);
$datetime2 = date_create($date2);
$interval = date_diff($datetime1, $datetime2);
if($interval->format('%a') < 30){
	if(isset($_SESSION['listened_tracks'])){
		$_SESSION['listened_tracks']= array_values(array_flip(array_flip($_SESSION['listened_tracks'])));
		for($i=0;$i<count($_SESSION['listened_tracks']);$i++){
			if($_SESSION['listened_tracks'][$i] == $model->id){
				$isnew = '';
				break;
			} else {
				$isnew = 'green';
			}
		}
	} else {
		$isnew = 'green';
	}
} else {
	$isnew = '';
}

if(!Yii::$app->user->isGuest){
	if(!Yii::$app->user->identity->premium > 0){
		$name = explode('.mp3',trim(str_replace('/audio/','',$model->path)))[0].'.mp3';
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/frontend/web/audio/min/'.$name)){}else{
			echo $name;
			$path = explode('.mp3',trim($_SERVER['DOCUMENT_ROOT'].'/frontend/web'.$model->path))[0].'.mp3';
			$endpath = trim($_SERVER['DOCUMENT_ROOT'].'/frontend/web/audio/min/'.$name);
			MpegAudio::fromFile($path)->trim(20, 30)->saveFile($endpath);
		}
	}
}
if(Yii::$app->user->isGuest){
		$name = explode('.mp3',trim(str_replace('/audio/','',$model->path)))[0].'.mp3';
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/frontend/web/audio/min/'.$name)){}else{
			echo $name;
			$path = explode('.mp3',trim($_SERVER['DOCUMENT_ROOT'].'/frontend/web'.$model->path))[0].'.mp3';
			$endpath = trim($_SERVER['DOCUMENT_ROOT'].'/frontend/web/audio/min/'.$name);
			MpegAudio::fromFile($path)->trim(20, 30)->saveFile($endpath);
		}
}
//$tag = id3_get_tag( $path );
//print_r($tag);
if(!isset($isnew)){
	$isnew = '';
}
if($model->filename == 'Скриптонит vs.Dillon Francis-Цепи(djGraff mash mix).mp3'){
	$tone_n_bpm_string = 'Bpm: 80, key: 7A';
	$tone = '7A';
	$bpm = '80';
}
//checking if user already downloaded this track
if(!Yii::$app->user->isGuest){
	$dld_u = explode(',', $model->downloaded_users);
	$is_dld = 'data-dawnloaded="false"';
	foreach($dld_u as $k=>$v){
		if($v == Yii::$app->user->identity->id){
			$is_dld = 'data-dawnloaded="true"';
			break;
		}
	}
}
if(!isset($_SESSION['numeracia_top'])){
	$_SESSION['numeracia_top'] = 0;
}
$_SESSION['numeracia_top']++;
if($_SESSION['numeracia_top'] > 10){
	$_SESSION['numeracia_top'] = 1;
}
?>

<?php if($model->filename !== '' && !empty($model->filename)){ ?>
	<?php if(Yii::$app->user->isGuest){ ?>
		<li class="awp-playlist-item" data-tone="<?php echo $tone;?>" data-bpm="<?php echo $bpm;?>" data-type="audio" data-mp3="<?php echo '/audio/min/'.$name;?>" data-title="<?=$_SESSION['numeracia_top'].'. '?><?=$model->filename?> <br> <span class='bpm-n-tone'><?php echo $tone_n_bpm_string;?></span> " data-download="/site/about/"></li> 
	<?php } elseif(Yii::$app->user->identity->premium > 0){ ?>
		<li class="awp-playlist-item" <?php echo $is_dld;?> <?php echo $isnew;?> data-tone="<?php echo $tone;?>" data-bpm="<?php echo $bpm;?>" data-type="audio" data-mp3="<?=$model->path?>" data-title="<?=$_SESSION['numeracia_top'].'. '?><?=$model->filename?> <br> <span class='bpm-n-tone'><?php echo $tone_n_bpm_string;?></span> " data-download="<?=$model->path?>"></li> 
	<?php } else { ?>
		<li class="awp-playlist-item" <?php echo $isnew;?> data-tone="<?php echo $tone;?>" data-bpm="<?php echo $bpm;?>" data-type="audio" data-mp3="<?php echo '/audio/min/'.$name;?>" data-title="<?=$_SESSION['numeracia_top'].'. '?><?=$model->filename?> <br> <span class='bpm-n-tone'><?php echo $tone_n_bpm_string;?></span> " data-download="/site/about/"></li> 
	<?php } ?>
<?php } ?>