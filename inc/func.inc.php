<?php
/** 获取当前访问的文件名 */
function getFileName(){
	$url = $_SERVER['PHP_SELF']; 
	$uri= substr( $url , strrpos($url , '/')+1 ); 
	if ($_SERVER["QUERY_STRING"])
	{
		$uri .= '?'.$_SERVER["QUERY_STRING"];
	}
	return $uri; 
}

/** 跳转 */
function jump($url){
	Header("HTTP/1.1 303 See Other"); 
	Header("Location: $url"); 
	exit;
}

/** 将对象转化为数组
 * @param  object $obj 要转化的对象
 * @return array 返回数组
 */
function objToArr($obj){
	$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
	foreach ($_arr as $key => $val){
		$val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
		$arr[$key] = $val;
	}
	return $arr;
}

//二维数组，按其中某个键值排序
function multiSort(&$array, $key_name, $sort_order = 'SORT_ASC', $sort_type = 'SORT_REGULAR') {
	if (!is_array($array)) {
	   return $array;
	}
	$arg_count = func_num_args();
	for ($i = 1; $i < $arg_count; $i++) {
	   $arg = func_get_arg($i);
	   if (!preg_match('/SORT/', $arg)) {
		$key_name_list[] = $arg;
		$sort_rule[] = '$'.$arg;
	   } else {
		$sort_rule[] = $arg;
	   }
	}
	foreach ($array as $key => $info) {
	   foreach ($key_name_list as $key_name) {
		${$key_name}[$key] = $info[$key_name];
	   }
	}
	$eval_str = 'array_multisort('.implode(',', $sort_rule).', $array);';
	eval($eval_str);
	return $array;
}

/** 验证是否为数字，maxlen可规定最大长度
 * @param  string  $value 数字
 * @param  string  $maxlen 最大长度
 * @param  boolean  $zeroAllow 是否允许数字为0
 * @return boolean  true为是,false为否
 */
function isNum($value, $maxlen=0,$zeroAllow = false)
{
	$reg = '/^[1-9]+[0-9]*$/';
	if($zeroAllow){
		$reg = '/^0$|^[1-9][0-9]*$/';
	}
	if(!preg_match($reg,$value))
	{
		return false;
	}
	if($maxlen > 0 && strlen($value) > $maxlen)
	{
		return false;
	}
	return true;
}

/** 验证是否为URL
 * @param  string  $url 
 * @return boolean  true为是,false为否
 */
function isUrl($url){
	if(preg_match('|^http(s)?://(.)+/$|',$url)){
		 return true;
	}
	return false;
}

/** 验证是否为主机地址
 * @param  string  $host 主机
 * @return boolean  true为是,false为否
 */
function isHost($host){
	if(preg_match('#^([0-9]{1,3}\.){3}[0-9]{1,3}$|^[a-z0-9-]+(.[a-z]+)+$#i',$host)){
		 return true;
	}
	return false;
}

/** 验证是否为端口
 * @param  string  $port 端口
 * @return boolean  true为是,false为否
 */
function isPort($port){
	if(preg_match('|^[0-9]{1,5}$|',$port)){
		 return true;
	}
	return false;
}

/** 将post变量注册成数组
 * @param  array  $keyArr 需要注册的变量键值数组
 * @return array  结果数组，如果没有post对应的值则对应键值为空
 */
function postAssign(array $keyArr){
	$assignArr = array();
	foreach ($keyArr as $value){
		$assignArr[$value] = isset($_POST[$value]) ? $_POST[$value]: '';
	}		
	return $assignArr;
}

/** 将变量数组注册到smarty里面 */
function assignAll($smarty,$valueArr){
	foreach ($valueArr as $key => $value){
			$smarty->assign($key,$value);
	}
}

/** 另存为 
 *  @param string  $fileName userInfoXml文件名
 */
function saveAs ($xmlPath,$fileName){
	header('Content-type: application/xml');   
	header('Content-Disposition: attachment; filename="'.$fileName.'"');   
	readfile($xmlPath.$fileName); 
}

/** firephp 配置函数 */
function firephp(){
	ob_start();
	FB::log('Hello World !'); // 常规记录
	FB::group('Test Group A'); // 记录分组
	// 以下为按照不同类别或者类型进行信息记录
	FB::log('Plain Message');
	FB::info('Info Message');
	FB::warn('Warn Message');
	FB::error('Error Message');
	FB::log('Message','Optional Label');
	FB::groupEnd();
	FB::group('Test Group B');
	FB::log('Hello World B');
	FB::log('Plain Message');
	FB::info('Info Message');
	FB::warn('Warn Message');
	FB::error('Error Message');
	FB::log('Message','Optional Label');
	FB::groupEnd();
	// 将信息作为table输出
	$table[] = array('Col 1 Heading','Col 2 Heading','Col 2 Heading');
	$table[] = array('Row 1 Col 1','Row 1 Col 2','Row 1 Col 2');
	$table[] = array('Row 2 Col 1','Row 2 Col 2');
	$table[] = array('Row 3 Col 1','Row 3 Col 2');
	FB::table('Table Label', $table);
	// 在异常处理中使用FirePHP
	class MyException extends Exception{
		public function  __construct($message, $code) {
			parent::__construct($message, $code);
		}
		public function log(){
			FB::log($this->getMessage());
		}
	}
	try{
		echo 'MoXie';
		throw new MyException('some description',1);
	}catch(MyException $e){
		$e->log();
	}	
	
}
?>