<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use common\models\Audio;
use common\models\Categories;
use yii\bootstrap\Tabs;
use common\models\User;
//use common\models\Djs;
use common\models\Downloads;
use frontend\models\SignupForm;

if(in_array('en' ,explode('/', $_SERVER['HTTP_REFERER']))){
	$site_now_language = "en";
} else {
	$site_now_language = "ru";
}

function generatePassword($length = 16){
  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}
function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
	return $randomString;

	}
	
if(isset($_GET)){
	if(isset($_GET['paymentform'])){
		if($_GET['paymentform'] == 'whatdoesitsaid'){
			$pay_user = User::find()->where(['<>','premiumcheck', ''])->all();
			foreach($pay_user as $us=>$fi){
				
				$premiumcheck = $fi->premiumcheck;
					
				$key = "60535a31595579396b435f494c345342605e60695f567134545277";
				$url = 'https://wl.walletone.com/checkout/InvoicingApi/v1.5/invoices/'.$premiumcheck.'/';
				$merch_id = '174786962927';
				$date = gmdate("Y-m-d\TH:i:s");
				$data = Array ($url,$merch_id,$date,$key);
				$secret_str = '';
				foreach ($data as $k => $v) {
					$v = iconv("windows-1251", "utf-8", $v);
					$secret_str .= $v;
				}
				$signature = base64_encode(pack("H*", md5($secret_str)));
				
				$headr = array();
				$headr[] = 'Content-type: application/json; charset=utf-8';
				$headr[] = 'X-Wallet-UserId: 174786962927';
				$headr[] = 'X-Wallet-Timestamp: '.gmdate("Y-m-d\TH:i:s");
				$headr[] = 'X-Wallet-Signature: '.$signature;
				
				$crl = curl_init($url);
				curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
				curl_setopt($crl, CURLOPT_URL,$url);
				curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
											
				$rest = json_decode(''.curl_exec($crl).'');
				curl_close($crl);
				
				if(property_exists($rest,'Invoice')){
					if($rest->Invoice->InvoiceStateId == 'Accepted'){
						$customer = User::findOne($fi->id);
						$customer->premiumcheck = '';
						$customer->premiumdate = date('Y-m-d H:i:s');
						$customer->premium = 60;
						
						$premium_count = $customer->stat_count_premium + 1;
						$customer->stat_count_premium = $premium_count;
						$customer->stat_is_premium = 1;
						$customer->save();
					} else {
					}
				} else {
				}
			}
		}
	}
}
if(isset($_POST['action'])){
	if($_POST['action'] == 'compilation'){
		$model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
					if(isset($_POST)){
						if($_POST['SignupForm']['email'] && Yii::$app->user->identity->confirmemail == 0){ //$site_now_language = "en"
							if($site_now_language == "en"){
								$textbodey = 'Hello! You have successfully registered at MyTrackStore.com. It remains only to confirm your email address. To do this, type the link in the address bar of the browser:';
								$content23 = 'Hello! You have successfully registered at MyTrackStore.com. <br> <br> It remains only to confirm your email address. <br> To do this, follow the link or type it in the browser\'s address page: <a target="_blank" href="http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'].'">http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'].'</a>';
								$send = Yii::$app->mailer->compose()
									->setFrom(['robot-search@mytrackstore.com' => 'Mytrackstore'])
									->setTo($_POST['SignupForm']['email'])
									->setSubject($_POST['SignupForm']['username'].', '.Yii::t('app', 'Вы зарегистрировались на сайте MyTrackStore.com'))
									->setTextBody($textbodey.' http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'])
									->setHtmlBody($content23)
									->send();
							} else {
								$textbodey = Yii::t('app','Здравствуйте! Вы успешно зарегистрировались на сайте MyTrackStore.com. Осталось только подтвердить ваш электронный адрес. Для этого вбейте ссылку в адресной строке браузера:');
								$content23 = Yii::t('app','Здравствуйте! Вы успешно зарегистрировались на сайте MyTrackStore.com. <br><br> Осталось только подтвердить ваш электронный адрес. <br>Для этого пройдите по ссылке или вбейте ее в адресной страке браузера:').' <a target="_blank" href="http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'].'">http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'].'</a>';
								$send = Yii::$app->mailer->compose()
									->setFrom(['robot-search@mytrackstore.com' => 'Mytrackstore'])
									->setTo($_POST['SignupForm']['email'])
									->setSubject($_POST['SignupForm']['username'].', '.Yii::t('app', 'Вы зарегистрировались на сайте MyTrackStore.com'))
									->setTextBody($textbodey.' http://mytrackstore.com/profile?myId='.Yii::$app->user->identity->id.'&checkWord='.$_POST['SignupForm']['checkmailcode'])
									->setHtmlBody($content23)
									->send();
							}
						}
					}
                    $p_check = rand(1,99999)."-".rand(0,999);
					$customer = User::findOne(Yii::$app->user->identity->id);
					$customer->premiumcheck = $p_check ;
					$customer->save();
					
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
					 print "<p>".Yii::t('app', 'Поздравляем! Вы успешно прошли регистрацию. На вашем почтовом ящике уже лежит письмо от нас.')."</p>";
					 print "<p>".Yii::t('app', 'Произведите оплату по кнопке Преобрести премиум, после чего нажмите на кнопку Подтвердить оплату')."</p>";
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
												},3000);
											},
										});
									});
								  </script><?
					
                }
            }
        }
	}
}
if(isset($_POST['whatsnow'])){
		if (isset($_POST['g-recaptcha-response'])) {
			$url_to_google_api = "https://www.google.com/recaptcha/api/siteverify";

			$secret_key = '6LdOwWYUAAAAAKvt7BuzGqNtMwB5pshq9U_nAmUr';

			$query = $url_to_google_api . '?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR'];

			$data = json_decode(file_get_contents($query));

			if ($data->success) {
				$treatcode = generatePassword(16);
				$users = User::findOne(['id'=>Yii::$app->user->identity->id]);
				$users->treatcode = $treatcode;
				$users->save();
				
				if($_POST['whatsnow'] == 'stopemail'){
					$subject = Yii::$app->user->identity->username.'!'.Yii::t('app', 'Ваш запрос на приостановление подписки на рассылку');
					$text_subject = Yii::t('app', 'Вы получили это письмо, потому что являетесь зарегистрированным пользователем сайта mytrackstore.com').'
					<br>';
					$text_subject .= Yii::t('app', 'Для того, чтобы отписаться от рассылки пройдите по ссылке ниже. Если вы не отправляли данного запроса, то игнорируйте это письмо и смените пароль перейдя по').' <a href="http://mytrackstore.com/profile/password" target="_blank">'.Yii::t('app', 'этой ссылке').'</a>';
					$linka = '<br><a href="http://mytrackstore.com/?treatcode='.$treatcode.'&id='.Yii::$app->user->identity->id.'&useraction='.$_POST['whatsnow'].'" target="_blank">'.Yii::t('app', 'Перейдите по этой ссылке').'</a>';
					$text_subject .= $linka;
				} elseif($_POST['whatsnow'] == 'deleteaccount'){
					$subject = Yii::$app->user->identity->username.'!'.Yii::t('app', 'Ваш запрос на удаление аккаунта');
					$text_subject = Yii::t('app', 'Вы получили это письмо, потому что являетесь зарегистрированным пользователем сайта mytrackstore.com').'
					<br>';
					$text_subject .= Yii::t('app', 'Для того, чтобы удалить ваш аккаунт пройдите по ссылке ниже. Если вы не отправляли данного запроса, то игнорируйте это письмо и смените пароль перейдя по').' <a href="http://mytrackstore.com/profile/password" target="_blank">'.Yii::t('app', 'этой ссылке').'</a>';
					$linka = '<br><a href="http://mytrackstore.com/?treatcode='.$treatcode.'&id='.Yii::$app->user->identity->id.'&useraction='.$_POST['whatsnow'].'" target="_blank">Перейдите по этой ссылке</a>';
					$text_subject .= $linka;
				} elseif($_POST['whatsnow'] == 'startemail') {
					$subject = Yii::$app->user->identity->username.'!'.Yii::t('app', 'Ваш запрос на восстановление подписки на рассылку');
					$text_subject = Yii::t('app', 'Вы получили это письмо, потому что являетесь зарегистрированным пользователем сайта mytrackstore.com').'
					<br>';
					$text_subject .= Yii::t('app', 'Для того, чтобы восстановить подписку пройдите по ссылке ниже. Если вы не отправляли данного запроса, то игнорируйте это письмо и смените пароль перейдя по').' <a href="http://mytrackstore.com/profile/password" target="_blank">'.Yii::t('app', 'этой ссылке').'</a>';
					$linka = '<br><a href="http://mytrackstore.com/?treatcode='.$treatcode.'&id='.Yii::$app->user->identity->id.'&useraction='.$_POST['whatsnow'].'" target="_blank">Перейдите по этой ссылке</a>';
					$text_subject .= $linka;
				} else {
					$subject = Yii::$app->user->identity->username.'!'.Yii::t('app', 'В ваш профиль кто-то зашёл.');
					$text_subject = Yii::t('app', 'Рекомендуем сменить пароль перейдя по').' <a href="http://mytrackstore.com/profile/password" target="_blank">'.Yii::t('app', 'этой ссылке').'</a>';
				}
				
				
				
				if(!empty(Yii::$app->user->identity->email)){
					$send = Yii::$app->mailer->compose()
						->setFrom(['robot-search@mytrackstore.com' => 'Mytrackstore'])
						->setTo(Yii::$app->user->identity->email)
						->setSubject($subject)
						->setTextBody($text_subject)
						->setHtmlBody($text_subject)
						->send();
				}
				echo '<p class="sucess">Вам отправлено письмо на ваш почтовый электронный адрес. Перейдите по ссылке в письме для подтверждения.</p>';
			} else {
				echo('Вы не прошли валидацию reCaptcha или уже отправляли запрос, в таком случае - обновите страницу!');
			}
		}
}
if(isset($_POST['createinvoice'])){
	$key = "60535a31595579396b435f494c345342605e60695f567134545277";
	$url = 'https://wl.walletone.com/checkout/InvoicingApi/v1.5/invoices/'.Yii::$app->user->identity->premiumcheck.'/';
	$merch_id = '174786962927';
	$date = gmdate("Y-m-d\TH:i:s");
	$data = Array ($url,$merch_id,$date,$key);
	$secret_str = '';
	foreach ($data as $k => $v) {
		$v = iconv("windows-1251", "utf-8", $v);
		$secret_str .= $v;
	}
	$signature = base64_encode(pack("H*", md5($secret_str)));
	
	$headr = array();
	$headr[] = 'Content-type: application/json; charset=utf-8';
	$headr[] = 'X-Wallet-UserId: 174786962927';
	$headr[] = 'X-Wallet-Timestamp: '.gmdate("Y-m-d\TH:i:s");
	$headr[] = 'X-Wallet-Signature: '.$signature;
	
	$crl = curl_init($url);
	curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
	curl_setopt($crl, CURLOPT_URL,$url);
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
								
	$rest = json_decode(''.curl_exec($crl).'');
	curl_close($crl);
	
	if(property_exists($rest,'Invoice')){
		if($rest->Invoice->InvoiceStateId == 'Accepted'){
			$customer = User::findOne(Yii::$app->user->identity->id);
			$customer->premiumcheck = '';
			$customer->premiumdate = date('Y-m-d H:i:s');
			$customer->premium = 60;
			
			$premium_count = $customer->stat_count_premium + 1;
			$customer->stat_count_premium = $premium_count;
			$customer->stat_is_premium = 1;
			$customer->save();
			echo '<style>.ramka-offer{display:none !important}</style><h3 style="color:green">Поздравляем!</h3><p>Вы успешно произвели оплату и стали пользователем класса премиум!</p><script>location.reload();</script>';
		} else {
			echo '<h3 style="color:red">Ошибка!</h3><p>Ваша оплата ещё не была произведена!</p>';
		}
	} else {
		echo '<h3 style="color:red">Ошибка!</h3><p>Ваша оплата ещё не была произведена!</p>';
	}
}

if(isset($_POST['category'])){
	if(!Yii::$app->user->isGuest){
		$modaro = User::findOne(['id'=>Yii::$app->user->identity->id]);
		$hallo = Yii::$app->user->identity->whatched_category.','.$_POST['category'];
		$modaro->whatched_category = $hallo;
		$modaro->date_of_watched_category = date('Y-m-d H:i:s');
		$modaro->save();
		
		$_SESSION['listened_categories'] = explode(',',Yii::$app->user->identity->whatched_category);
		
		if(!isset($_SESSION['listened_categories']) || gettype($_SESSION['listened_categories']) == 'string'){
			$_SESSION['listened_categories'] = [];
		} else {
			$_SESSION['listened_categories']= array_values(array_flip(array_flip($_SESSION['listened_categories'])));
		}
		
			echo "<script>
				for(var i=0;i<$('.nav.nav-tabs li a').length;i++){
					if($('.nav.nav-tabs li a:eq('+i+')').attr('red') == ''){
						if($('.nav.nav-tabs li a:eq('+i+')').html() == '".$_POST['category']."'){
							$('.nav.nav-tabs li a:eq('+i+')').removeAttr('red');
						}
					}
				}
			</script>";
		
	}
}

if(isset($_POST['id'])){
	if(!isset($_SESSION['listened_tracks']) || gettype($_SESSION['listened_tracks']) == 'string'){
		$_SESSION['listened_tracks'] = [];
	}
	if(!isset($_SESSION['listened_categories']) || gettype($_SESSION['listened_categories']) == 'string'){
		$_SESSION['listened_categories'] = [];
	} else {
		$_SESSION['listened_categories']= array_values(array_flip(array_flip($_SESSION['listened_categories'])));
	}
	if(!Yii::$app->user->isGuest){
		$modaro = User::findOne(['id'=>Yii::$app->user->identity->id]);
		$hallo = Yii::$app->user->identity->listened_tracks.','.$_POST['id'];
		$modaro->listened_tracks = $hallo;
		$modaro->save();
	
		$_SESSION['listened_tracks'] = array_values(array_flip(array_flip(explode(',',Yii::$app->user->identity->listened_tracks))));
		//print_r($_SESSION['listened_tracks']);
		$ars = Categories::find(['<>','id', 0])->all();
		foreach($ars as $k=>$v){
				$break = '';
				$audios = Audio::find()->where(['category'=>$v->id])->orderBy('adddate DESC')->all();
				foreach($audios as $keyp=>$valuep){
					$date1 = ''.$valuep->adddate.'';
					$date2 = ''.date('Y-m-d H:i:s').'';

					$datetime1 = date_create($date1);
					$datetime2 = date_create($date2);
					$interval = date_diff($datetime1, $datetime2);
					if($interval->format('%a') < 30){
						for($i=0;$i<count($_SESSION['listened_tracks']);$i++){
							if($_SESSION['listened_tracks'][$i] == $valuep->id){
								for($up=0;$up<count($_SESSION['listened_categories']);$up++){
									if(isset($_SESSION['listened_categories'][$up]) && $_SESSION['listened_categories'][$up] == $v->name){
										$_SESSION['listened_categories'] = [];
										$break = 'break';
									}
								}
							}
							else {
								if($break !== 'break'){
									$_SESSION['listened_categories'][] = $v->name;
								}
							}
						}
					}
				}
		}
	}
	if(Yii::$app->user->isGuest){
		$is_premium =0;
	} else {
		$is_premium = Yii::$app->user->identity->premium;
	}
	
	if($is_premium == 0){
		if(isset($_SESSION['proslushka'])){
			$_SESSION['proslushka'] = $_SESSION['proslushka']+1;
		} else {
			$_SESSION['proslushka'] = 1;
		}
	} else {
		$_SESSION['proslushka'] = 0;
	}
	$_SESSION['proslushka'] = 0;
	if($_SESSION['proslushka'] > 10){
		//echo '<script>alert("Вы превысили лимит прослушивания! Зарегистрируйтесь и получите возможность безлимитного прослушивания и скачивания:)");awp_player.destroyMedia();awp_player.destroy();</script>';
	}
}
if(isset($_POST['itsuploaded'])){
	$modaro = Audio::find()->where(['path' => $_POST['trackpath']])->one();
	
	$dj_id = $modaro->dj_id;
	$track_id = $modaro->id;
	$dld_users = $modaro->downloaded_users;
	
	$modaro->downloaded_users = $dld_users.','.Yii::$app->user->identity->id;
	
	$modaro->views = ($modaro->views)+1;
	$modaro->save();
	if(!Yii::$app->user->isGuest){
		$is_premium = Yii::$app->user->identity->premium;
		if($is_premium > 0){
			//for premium users djGraff7011983 765892
			$users = User::findOne(['id'=>Yii::$app->user->identity->id]);
			if($is_premium == 1){
				$users->premium = $is_premium-1;
				$users->save();
				echo '<script>alert("Вы превысили лимит скачивания! Зарегистрируйтесь и получите возможность безлимитного прослушивания и скачивания:)");setInterval(function(){$(".awp-download").removeAttr("onlick");$(".awp-download").removeAttr("download");$(".awp-download").attr("href","about");},100);</script>';
			
			} else {
				$users->premium = $is_premium-1;
				$users->save();
			}
			
		} else {
			//for offten users
			echo '<script>alert("Вы превысили лимит скачивания! Зарегистрируйтесь и получите возможность безлимитного прослушивания и скачивания:)");setInterval(function(){$(".awp-download").removeAttr("onlick");$(".awp-download").removeAttr("download");$(".awp-download").attr("href","about");},100);</script>';
		}
	}
	$downloads = new Downloads();
					
	$downloads->dj_id = $dj_id;
	$downloads->track_id = $track_id;
	$downloads->date = date('Y-m-d H:i:s');
					
	$downloads->save();
}
if(isset($_POST['getlist'])){?>
	<?php
		$sh = $_POST['query'];
		$sh2 = $_POST['query2'];
		$query = Audio::find()->where(['REGEXP', 'filename',$sh])->all();
		$query2 = Audio::find()->where(['REGEXP', 'filename',$sh2])->all();
		
		$arr1 = array();
		foreach($query as $key=>$value) {
		   $arr1[] = $value->id;
		}
		foreach($query2 as $key=>$value) {
		   $arr1[] = $value->id;
		}
		$arr2 = array_values(array_flip(array_flip($arr1)));
		$query = Audio::find()->where(['id'=>$arr2]);
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => false
		]);
						 
		echo ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_list',
		]); 
	?>
<?php
}
exit();
?>