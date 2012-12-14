<?php
/** 路由类 */
class Route{
	private $smarty;
	private $gametest; 
	
    /*构造函数，完成类的初始化 */
    public function __construct($smarty,$gametest) {
		$this->smarty = $smarty;
		$this->gametest = $gametest;
    }
	
    /**
	 * 处理路由参数，完成对相关分组函数的调用
	 * @access public
	 * @param  string   $module   模块
	 * @param  string   $action   动作
	 */
	public function deal ($module,$action) 
	{
		$module = $module ? $module : 'gametest';
		$funcName = 'module'.ucfirst($module);
		$this->$funcName($action);
	}
	
	/**
	 * 游戏测试模块，完成相关函数的调用
	 * @access private
	 * @param  string   $action   动作
	 */
	private function moduleGametest($action)
	{
		if($action === 'api' && isset($_REQUEST['method']))
		{
			echo $this->gametest->api($_REQUEST['method']);
			exit;
		}
		switch ($action) {
			case 'set' :
				$clientNum = $this->gametest->getTotalNum('client');
				$serverNum = $this->gametest->getTotalNum('server');
				$this->smarty->assign('clientNum',$clientNum);
				$this->smarty->assign('serverNum',$serverNum);
				$this->smarty->assign('clientArr',$this->gametest->allList('client'));
				$this->smarty->display('gametest/'.$action.'.tpl');
				exit;
			case 'main' :
				$info = $this->gametest->main();
				$this->smarty->assign('msg',$info['msg']);
				$this->smarty->assign('jsonFlex',$info['jsonFlex']);
				$this->smarty->display('gametest/'.$action.'.tpl');
				exit;
			default :
				$keyArr = array(
					'pid',
					'client',
					'server',
					'customUrl',
					'customDebug',
					'customHost',
					'customPort'
				);
				$assignArr = postAssign($keyArr);
				assignAll($this->smarty,$assignArr);
				
				$this->gametestLogin();
				
				$action = 'index';
				$this->smarty->assign('clientArr',$this->gametest->allList('client'));
				$this->smarty->assign('serverArr',$this->gametest->allList('server'));
				$this->smarty->display('gametest/'.$action.'.tpl');
		}
	}
	
	/** 处理游戏测试入口的登陆，并完成相关tips,openWin，s三个模板变量的注册 */
	private function gametestLogin(){
		$loginResult = array(
			'tips' => '',
			'openWin' => '',
			's' => '',
		);
		if(isset($_POST['login'])){
			$loginResult = $this->gametest->login();
		}
		$this->smarty->assign('tips',$loginResult['tips']);
		$this->smarty->assign('openWin',$loginResult['openWin']);
		$this->smarty->assign('s',$loginResult['s']);	
	}
}
?>