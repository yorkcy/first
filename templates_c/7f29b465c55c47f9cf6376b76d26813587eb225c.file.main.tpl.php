<?php /* Smarty version Smarty-3.1.12, created on 2012-12-13 10:15:25
         compiled from ".\templates\gametest\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1975650c93a3deb3b32-27233958%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f29b465c55c47f9cf6376b76d26813587eb225c' => 
    array (
      0 => '.\\templates\\gametest\\main.tpl',
      1 => 1355121841,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1975650c93a3deb3b32-27233958',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msg' => 0,
    'jsonFlex' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_50c93a3defdff4_00437662',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50c93a3defdff4_00437662')) {function content_50c93a3defdff4_00437662($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>游戏测试 - (<?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
）</title>
<style>
html, body { height:100%; overflow:hidden}
body { margin:0; padding:0; background-color: #000000;color:#FFFFFF; }
.normalScreen {width:1128px; height:603px; position:absolute;top:50%;left:50%;margin:-315px 0 0 -564px;}
.fullScreen {width:100%; height:100%;position:absolute;}
</style>
</head>
<body>
<div id='screen' class='fullScreen'>
<div id="flashObj" style="FONT-SIZE: 14px; COLOR: #dedede; text-align:center">
<p><font color="white">游戏正在加载中，请稍等...</font></p>
<img src="./resource/images/process_bar.gif">
</div>
<script src="resource/js/jquery.js" language="javascript"></script>
<script src="resource/js/swfobject.js" language="javascript"></script>
<script type="text/javascript">
window.onerror=function(){return true;}

function callbackFn(callbackObj)
{
	if(callbackObj.success == true)
	{
	}
	else
	{
		$("#bar").remove();
		$("#flashObj").html('<h1>亲，为了让您更流畅的游戏，请您下载安装flash player9.0以上的播放器。</h1><p><a href="http://www.adobe.com/go/getflashplayer">点击此处，下载Flash播放器（Get Adobe Flash player）</a></p>');
	}
}
var flashvars = eval('(<?php echo $_smarty_tpl->tpl_vars['jsonFlex']->value;?>
)');
var params = {};
params.quality = "high";
params.bgcolor = "#000000";
params.allowscriptaccess = "always";
params.allowFullScreen = true;

var attributes = {};
attributes.id = "gameObj";
attributes.name = "gameObj";
attributes.align = "middle";
var width = '100%';
var height = '100%';

var gameSwf = 'LoaderModule.swf';
if (swfobject.hasFlashPlayerVersion("11.1"))
{
        gameSwf = 'LoaderModule_v11.swf';
        params.wmode = "direct";
}
else
{
        params.wmode = "window";
}
swfobject.embedSWF(flashvars.mapResURL+gameSwf+"?r="+Math.random(), "flashObj", width, height, "10.0.0", "", flashvars, params, attributes, callbackFn);
	
</script>
</div>
</body>
</html><?php }} ?>