<?php
#Массив с параметрами, которые нужно передать методом POST к API системы
require_once 'login.php';

$user=array(
  'USER_LOGIN'=> $un, #Ваш логин (электронная почта)
 'USER_HASH'=> $hash #Хэш для доступа к API (смотрите в профиле пользователя)
);

$subdomain='dkovskij'; #Наш аккаунт - поддомен

$name = $_REQUEST['name'];
$sale = $_REQUEST['sale'];
$option = $_REQUEST['option'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];

$leads['add']=array(
  array(
    'name' => 'Заявка из формы на сайте',
    'status_id'=> 1,
    'sale'=> $sale,
    'responsible_user_id'=>24413680,
    'tags' => 'Неразобранное', #Теги
   	'custom_fields'=>array(
        'id'=>427496, #Уникальный индентификатор заполняемого дополнительного поля
       	'values'=>array( # id значений передаются в массиве values через запятую
           1240665,
            1240664
      )
     )
  	)
);

$contacts['add']=array(
   array(
		'name' => $name,
		'responsible_user_id' => 24413680,
		'created_by' => 24413680,
		'tags' => "форма на сайте",
		// 'leads_id' => array( "1" ),
		'custom_fields' => array(
	        array(
	            'id' => 366369,
	            'values' => array(
	            	array(
					'value' => $phone,
					'enum' => "WORK"
				)
				)
			),

	        array(
	            'id' => 366371,
	            'values' => array(
	            	array(
					'value' => $email,
					'enum' => "WORK"
				)
				)
			),

			array(
	            'id' => 385063,
	            'values' => array(
	            	array(
					'value' => $option
				)
				)
			),

		)
	)
);

#Формируем ссылку для запроса
$link_auth='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';
$link='https://'.$subdomain.'.amocrm.ru/api/v2/leads';
$link_leads='https://'.$subdomain.'.amocrm.ru/api/v2/leads';
$link_contacts='https://'.$subdomain.'.amocrm.ru/api/v2/contacts';
$link_account='https://'.$subdomain.'.amocrm.ru/api/v2/account?with=custom_fields';
/* Нам необходимо инициировать запрос к серверу. Воспользуемся библиотекой cURL (поставляется в составе PHP). Вы также
можете
использовать и кроссплатформенную программу cURL, если вы не программируете на PHP. */
$curl=curl_init();

#Устанавливаем необходимые опции для сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link_auth);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
$out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера

$curl=curl_init(); #Сохраняем дескриптор сеанса cURL
#Устанавливаем необходимые опции для сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link_leads);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($leads));
curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
$out1=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$code1=curl_getinfo($curl,CURLINFO_HTTP_CODE);

$curl=curl_init(); #Сохраняем дескриптор сеанса cURL
#Устанавливаем необходимые опции для сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link_contacts);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($contacts));
curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
$out2=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$code2=curl_getinfo($curl,CURLINFO_HTTP_CODE);


$curl=curl_init(); #Сохраняем дескриптор сеанса cURL
#Устанавливаем необходимые опции для сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link_account);
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
$out3=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$code3=curl_getinfo($curl,CURLINFO_HTTP_CODE);


curl_close($curl);

$code=(int)$code;
$errors=array(
  301=>'Moved permanently',
  400=>'Bad request',
  401=>'Unauthorized',
  403=>'Forbidden',
  404=>'Not found',
  500=>'Internal server error',
  502=>'Bad gateway',
  503=>'Service unavailable'
);
try
{
  #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
 if($code!=200 && $code!=204)
    throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
}
catch(Exception $E)
{
  die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
}
/*
 Данные получаем в формате JSON, поэтому, для получения читаемых данных,
 нам придётся перевести ответ в формат, понятный PHP
 */
$Response=json_decode($out,true);
$Response=$Response['response'];
if(isset($Response['auth'])) #Флаг авторизации доступен в свойстве "auth"
 return 'Авторизация прошла успешно';
return 'Авторизация не удалась';

?>