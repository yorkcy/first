<?php
/** 游戏测试类 */
class Gametest
{
	private $xml; //xml对象
	private $path;
	private $fileName = 'gametest.config.xml';
	private $lanConfig;

	/** 构造函数 */
    public function __construct($path,$lanConfig)
    {
		$this->path = $path;
		$this->xml = simplexml_load_file($this->path['PUB_XML'].$this->fileName);
		$this->lanConfig = $lanConfig;
    }
	
	/**
	 * 游戏测试入口登录
	 * @return array  $result openWin健值表示是否打开游戏窗口，s为session_id，tips为信息不全时的提示
	 */	
	public function login(){
		$result['s'] = ''; //session_id
		$result['openWin'] = false; //是否打开游戏窗口
		$result['tips'] = ''; //提示

		$gameInfo = $this->getGameInfo();
		$tips = $this->createTips($gameInfo);
		if($tips)
		{
			session_destroy ();
			$result['tips'] = $tips;
			return $result;
		}
		$_SESSION['gameInfo'] = $gameInfo;
		/** 重新生成sessionID */
		session_regenerate_id();
		$s = session_id();
		$result['openWin'] = true;
		$result['s'] = $s;
		return $result;
	}
	
	/**
	 * 游戏测试入口登录的信息验证，返回验证通过的游戏信息
	 * @access public
	 * @return array  $gameInfo 游戏信息数组
	 */
	public function getGameInfo(){
		$gameInfo = array();
		if(isNum($_REQUEST['pid'])){
			$gameInfo['pid'] = $_REQUEST['pid'];
		}	
		$client = $this->loginClient();
		$server = $this->loginServer();
		$gameInfo = array_merge($gameInfo,$client,$server);
		return $gameInfo;
	}
	
	/**
	 * 游戏测试入口登录自定义客户端验证
	 * @access public
	 * @param  string  $url 
	 * @param  string  $debug 是否调试
	 * @return array  $clientInfo 包括client，url，debug三个键值
	 */
	public function loginClient(){
		$clientInfo = array();
		if(isset($_REQUEST['customUrl']) && isUrl($_REQUEST['customUrl'])){
			$clientInfo['client'] = '自定义';
			$clientInfo['url'] = $url;
			$clientInfo['debug'] = (int)$_REQUEST['customDebug']; //一定要转化为数字
			return $clientInfo;
		}
		if(!isset($_REQUEST['client']) || empty($_REQUEST['client'])){
			return $clientInfo;
		}
		$client = $this->getConfigByName('client',$_REQUEST['client']);
		if(!$client){
			return $clientInfo;
		}
		$clientInfo['client'] = (string)$client->name;
		$clientInfo['url'] = (string)$client->url;
		$clientInfo['debug'] = (int)$client->debug; //一定要转化为数字
		return $clientInfo;
	}
	
	/**
	 * 游戏测试入口登录自定义客户端验证
	 * @access public
	 * @param  string  $url 
	 * @param  string  $debug 是否调试
	 * @return array  $clientInfo 包括client，url，debug三个键值
	 */
	public function loginServer(){
		$serverInfo = array();
		if(isset($_REQUEST['customHost']) && isHost($_REQUEST['customHost'])){
			$serverInfo['server'] = '自定义';
			$serverInfo['host'] = $url;
			if (isPort($_REQUEST['customPort']))
			{
				$serverInfo['port'] = (int)$_REQUEST['customPort']; //一定要转化为数字
			}
			return $serverInfo;
		}
		if(!isset($_REQUEST['server']) || empty($_REQUEST['server'])){
			return $serverInfo;
		}
		$server = $this->getConfigByName('server',$_REQUEST['server']);
		if(!$server){
			return $serverInfo;
		}
		$serverInfo['server'] = (string)$server->name;
		$serverInfo['host'] = (string)$server->host;
		$serverInfo['port'] = (string)$server->port; //一定要转化为数字
		return $serverInfo;
	}
	
	/**
	 * 根据游戏信息验证结果数组生成提示数组
	 * @access public
	 * @param  array  $gameInfo 验证结果数组
	 * @return array  $tips 提示数组
	 */
	public function createTips(array $gameInfo){
		$tips = array();
		$checkResult = array(
			'pid' => 0,
			'url' => 0,
			'host' => 0,
			'port' => 0,
		);
		foreach($checkResult as $k=>$v){
			if(isset($gameInfo[$k])){
				$checkResult[$k] = 1;
			}
		}
		foreach($checkResult as $k => $v)
		{
			if($v===0)
			{
				$k = strtoupper($k);
				$tips[] = $this->lanConfig['ERR_'.$k];
			}
		}
		return $tips;
	}

	/** 获取进入游戏主界面的信息
	 *  return array $info 游戏配置信息
	 */
	public function main(){
		if(isset($_REQUEST['s']) && !empty($_REQUEST['s']))
		{
			session_id($_REQUEST['s']);
		}
		if(empty($_SESSION['gameInfo']))
		{
			echo '会话过期，请重新登录！<a href="index.php">返回</a>';
			exit;
		}
		
		$gameInfo = $_SESSION['gameInfo'];
		$now = time();
		
		$flex['host'] =  $gameInfo['host'];
		$flex['port'] =  $gameInfo['port'];
		$flex['sign'] = md5($gameInfo['pid'] . $now . rand(0,1000));
		$flex['pid'] = $gameInfo['pid'];
		$flex['time'] = $now;
		$flex['username'] = 'test';
		$flex['version'] = (string)$this->xml->version;
		$flex['gameURL'] = "WdqkClient.swf?v" . rand(0,10000);
		$flex['commURL'] = "CommModule.swf?v". rand(0,10000);
		$flex['logoURL'] = "assets/ui/logo_wdqk.swf?v". rand(0,10000);
		$flex['configURL'] = "config.json?v". rand(0,10000);
		$flex['mapResURL'] = $gameInfo['url'];
		
		$flex['rechargeURL'] = "";
		$flex['bbsURL'] = "";
		$flex['orgURL'] = "";
		$flex['newCardURL'] = "";
		$flex['userCenterURL'] = "";
		$flex['gmUrl'] = "";
		
		$flex['debug'] = $gameInfo['debug'] === 0 ? 0 : 1;
		
		$msg = "【客户端】：{$gameInfo['client']} {$gameInfo['url']} 【服务端】：{$gameInfo['server']} {$gameInfo['host']}:{$gameInfo['port']}";
		$info['msg']=$msg;	
		$info['jsonFlex'] = json_encode($flex);
		return $info;
	}
	
	/**
	 * 增加配置并获取配置总数
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  array  $fieldArr 字段数组
	 * @return array  $info result健值表示操作结果，totalNum是对应配置类型的总数
	 */
	public function add($type,$fieldArr)
	{
		$info = array();
		$info['result'] = $this->addConfig($type,$fieldArr);
		$info['totalNum'] = $this->getTotalNum($type);
		return $info;
	}	
	
	/**
	 * 增加配置
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  array  $fieldArr 字段数组
	 * @return   $info result健值表示操作结果
	 */
	public function addConfig($type,$fieldArr){
		$xml = $this->xml->addChild($type);
		//$xml->addAttribute("type", "small");
		$xml->addChild("name", $fieldArr['name']);
		$xml->addChild("order", $fieldArr['order']);
		switch ($type){
			case 'client' :
				$xml->addChild("url", $fieldArr['url']);
				$xml->addChild("debug",$fieldArr['debug']);
				break;
			case 'server' : 
				$xml->addChild("host", $fieldArr['host']);
				$xml->addChild("port",$fieldArr['port']);
				break ;
			default :
				return false ;
		}
		return $this->saveXml();
	}
	
	/**
	 * 修改配置
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  array  $fieldArr 字段数组
	 * @return boolean true表示修改成功，false表示修改失败
	 */
	public function modify($type,$fieldArr)
	{
		$singleConfig = $this->getConfigByName($type,$fieldArr['name']);
		if(!$singleConfig){
			return false;
		}
		$singleConfig->name = $fieldArr['rename'];
		$singleConfig->order = $fieldArr['order'];
		switch ($type){
			case 'client' :
				$singleConfig->url = $fieldArr['url'];
				$singleConfig->debug = $fieldArr['debug'];
				break;
			case 'server' :
				$singleConfig->host = $fieldArr['host'];
				$singleConfig->port = $fieldArr['port'];
				break;
			default :
				return false;
		}
		return $this->saveXml();
	}
	
	/**
	 * 保存xml
	 * @return  boolean  true为成功 ,false 为失败
	 */
	public function saveXml(){
		$this->setOptime();
		$result = $this->xml->asXML($this->path['PUB_XML'].$this->fileName);
		if($result){
			return true;	
		}	
		return false;
	}
	
	/**
	 * 获取所有client或server列表
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @return  array  $configList 配置数组
	 */
	public function allList($type)
	{
		$configList = array();
		$configArr = (array) $this->xml->xpath($type);
		foreach ($configArr as $configItem){
			$configList[] = objToArr($configItem);
		}
		if(empty($configList))
		{
			return false;	
		}
		$configList = multiSort($configList,'order');
		return $configList;
	}
	
	/**
	 * 获取配置信息，用于修改操作
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  string  $name 姓名
	 * @return array  $info exist健值表示是否存在
	 */
	public function configInfo($type,$name)
	{
		$info = array ();
		$singleConfig = $this->getConfigByName($type,$name);
		if(!$singleConfig){
			return $info;	
		}
		$info = objToArr($singleConfig);
		return $info;
	}
	
	/**
	 * 查找配置
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  string  $keyword  关键字
	 * @return array   $info  返回配置数组
	 */
	public function search($type,$keyword)
	{
		$configList = array();
		$configArr = (array) $this->xml->xpath($type);
		foreach ($configArr as $configItem){
			$pos = stripos((string)$configItem->name,$keyword);
			if($pos!==false)
			{
				$configList[] = objToArr($configItem);
			}
		}
		return $configList;
	}
	
	/**
	 * 删除选中的配置并获取配置总数
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  array  $nameArr 姓名数组
	 * @return  array  $info 删除结果数组，totalNum健值表示对应类型总数，success健数组表示删除成功的姓名
	 */
	public function delete($type,$nameArr){
		$info = $this->deleteConfig($type,$nameArr);
		$info['totalNum'] = $this->getTotalNum($type);
		return $info;
	}
	
	/**
	 * 删除选中的配置
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  array  $nameArr 姓名数组
	 * @return  array  $info 删除结果数组
	 */
	public function deleteConfig($type,$nameArr){
		$resultArr = array();
		$i=0;
		$configArr = (array) $this->xml->xpath($type);
		foreach ($configArr as $configItem){
			foreach ($nameArr as $name){
				if((string)$configItem->name===$name)
				{
					switch ($type){
						case 'client' :
							unset($this->xml->client[$i]);
							break;
						case 'server' :
							unset($this->xml->server[$i]);
							break;
						default :
							return false;
					}
					$resultArr['success'][] = $name;
					$i--;
					unset($nameArr[$name]);
					break;
				}
			}
			$i++;
		}
		$saveResult = $this->saveXml();
		if(!$saveResult){
			return false;
		}
		return $resultArr;
	}
	
	
	/**
	 * 修改配置序号
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  array  $nameArr 姓名数组
	 * @return  array  $info 删除结果数组
	 */
	public function order($type,$orderArr){
		$data = array (
			'err' => array (),
			'end' => false,
			'allList' => array (),
		);
		
		$errArr = $this->checkOrder($orderArr);
		if(!empty($errArr)){
			$data['err'] = $errArr;
			return $data;
		}
		
		$data['modifyNum'] = $this->orderConfig($type,$orderArr);
		$data['allList'] = $this->allList($type);
		return $data;
	}
	
	/**
	 * 验证排序号
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  array  $nameArr 姓名数组
	 * @return  array  $info 删除结果数组
	 */
	public function checkOrder($orderArr){
		$errArr = array();
		foreach ($orderArr as $key => $value){
			if(!isNum($value,0,true)){
				$errArr[$key] = $value;
			}
		}
		return $errArr;
	}
	
	/**
	 * 修改配置序号
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  array  $nameArr 姓名数组
	 * @return  array  $modifyNum 修改的数量
	 */
	public function orderConfig($type,$orderArr){
		$modifyNum = 0;
		foreach ($orderArr as $key => $value){
			$config = $this->getConfigByName($type,$key);
			if($config && (string)$config->order !== $value){
				$config->order = $value;
				$modifyNum++;
			}
		}
		$saveResult =  $this->saveXml();
		if(!$saveResult){
			return false;
		}
		return $modifyNum;
	}
	
	/**
	 * 验证姓名
	 * @access public
	 * @param  string  $type 类型，有client何server两种
	 * @param  string  $value 姓名
	 * @return  int  1表示可以使用,2表示已存在
	 */
	public function checkName($value)
	{
		if(trim($value) === ''){
			return VAL_EMPTY;
		}
		$checkResultCode=CAN_USE;
		foreach ($this->xml as $configItem){
			if((string)$configItem->name === $value)
			{
				$checkResultCode = HAD_EXIST;
				break;
			}
		}
		return $checkResultCode;
	}
	
	/**
	 * 验证字段格式
	 * @access public
	 * @param  string  $field 字段名
	 * @param  string  $value 值
	 * @return  int  1表示可以使用,3表示格式不符
	 */
	public function checkFormat($field,$value){
		$checkResultCode = FORMAT_ERROR;
		switch ($field){
			case 'url' :
				$result = isUrl($value);
				break;
			case 'host' :
				$result = isHost($value);
				break;
			case 'port' :
				$result = isPort($value);
				break;
			case 'order' :
				$result = isNum($value,0,true);
				break;
			default :
				return false;
		}
		if ($result)
		{
			$checkResultCode = CAN_USE;
		}
		return $checkResultCode;
	}
	
		/**
	 * 游戏测试模块，完成相关函数的调用
	 * @access private
	 * @param  string   $action   动作
	 */
	public function api($method){
		$json = '';
		switch ($method) {
			case 'checkName' :
				echo $this->$method($_POST['value']);
				exit;
			case 'checkFormat' :
				echo $this->$method($_POST['field'],$_POST['value']);
				exit;
			case 'add' :
			case 'modify' :
				$json = $this->$method($_POST['type'],$_POST['fieldArr']);
				break;
			case 'configInfo' :
				$json = $this->$method($_POST['type'],$_POST['name']);
				break;
			case 'search' :
				$json = $this->$method($_POST['type'],$_POST['keyword']);
				break;
			case 'getMaxOrder' :
			case 'allList' :
				$json = $this->$method($_POST['type']);
				break;
			case 'delete' :
				$json = $this->$method($_POST['type'],$_POST['nameArr']);
				break;
			case 'order' :
				$json =$this->$method($_POST['type'],$_POST['orderArr']);
				break;
			default :
				return false;
		}
		return json_encode($json);
	}
		
	/** 获取配置总数
	 *  @param string $type 类型
	 *  @return int 总数
	 */
	public function getTotalNum($type)
	{
		$configArr = (array) $this->xml->xpath($type);
		return count($configArr);
	}
	
	/** 获取单个配置配置
	 *  @param string $type 类型
	 *  @param string $name 姓名
	 *  @return 配置对象
	 */
	private function getConfigByName($type,$name){
		$pathStr = sprintf("/config/%s[name='%s']",$type,$name);
		$configObj = $this->xml->xpath($pathStr);
		return $configObj['0'];
	}
	
	/** 获取单个配置配置
	 *  @param string $type 类型
	 *  @param string $name 姓名
	 *  @return 配置对象
	 */
	private function getMaxOrder($type){
		$pathStr = sprintf("/config/%s/order",$type);
		$orderArr = $this->xml->xpath($pathStr);
		$max = 0;
		foreach ($orderArr as $v){
			$max = ((string)$v > $max ) ? (string)$v :$max;
		}
		return $max;
	}
	
	/** 获取单个配置配置
	 *  @param string $type 类型
	 *  @param string $name 姓名
	 *  @return 配置或false
	 */
	private function setOptime(){
		$this->xml->op_time = date('Y-m-d H:i:s' ,time());
	}
}
?>