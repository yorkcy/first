<?php
/** 初始化类 */
class Init{
	private $comConfig; //配置数组（二维）
	private $lanConfig; //语言配置数组
	private $pathResources; //路径配置数组
	private $smarty; //Smarty 对象
	private $gametest; //用户操作对象
	private $route; //路由对象 
	
    /*构造函数，完成相关类和配置的初始化 */
    public function __construct(array $path) {
		require($path['DEFINE_CONFIG']);
		/** 加载公共配置文件 */
		$this->comConfig = require($path['COM_CONFIG']);
		$this->pathResources = $path['RESOURCES'];
		/** 加载语言包 */
		$this->lanConfig = require($path['LANGUAGE']);
		/** 加载类和公共函数 */
		$this->autoLoad($path['FUNC_CLASS']);
		
		session_start();
		header('Content-Type: text/html; charset=utf-8');
		date_default_timezone_set($this->comConfig['DEFAULT_TIMEZONE']);
		
		$this->smarty= new Smarty;
		$this->smartyInit($this->comConfig['SMARTY']);
			
		$this->gametest= new Gametest($this->pathResources,$this->lanConfig['GAMETEST']);
		
		$this->route = new Route($this->smarty,$this->gametest);
    }
	
	public function getRoute ()
	{
		return $this->route;
	}
	
    /**
	 * 加载文件，包括类和函数
	 * @access private
	 * @param  array   $config   文件路径的一位数组
	 */
	private function autoLoad($config){
		foreach ($config as $path)
		{
			require($path);
		}
	}
	
	/* 初始化Smarty，完成配置 */
	private function smartyInit($config){
		$this->smarty->debugging =  $config['DEBUGGING'];
		$this->smarty->caching =  $config['CACHING'];
		$this->smarty->left_delimiter = $config['LEFT_DELIMITER'];
		$this->smarty->right_delimiter = $config['RIGHT_DELIMITER'];
	}
}
?>