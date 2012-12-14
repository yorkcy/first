<?php /* Smarty version Smarty-3.1.12, created on 2012-12-13 13:04:06
         compiled from ".\templates\gametest\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1203050c8732b31d5d8-83621406%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '477ef3655634ef6456dea3c3d27d19f24aba43b7' => 
    array (
      0 => '.\\templates\\gametest\\index.tpl',
      1 => 1355374443,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1203050c8732b31d5d8-83621406',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_50c8732b414d58_30655713',
  'variables' => 
  array (
    'tips' => 0,
    'msg' => 0,
    'pid' => 0,
    'clientArr' => 0,
    'configItem' => 0,
    'client' => 0,
    'serverArr' => 0,
    'server' => 0,
    'customUrl' => 0,
    'customDebug' => 0,
    'customHost' => 0,
    'customPort' => 0,
    'openWin' => 0,
    's' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50c8732b414d58_30655713')) {function content_50c8732b414d58_30655713($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<title>游戏测试配置</title>
<meta charset="utf-8">
<link href="resource/css/bootstrap.min.css" rel="stylesheet" media="screen">
<style>
.wrap{width:860px;margin:30px auto;}
</style>
</head>
<body>
<div class="wrap">
    <ul class="nav nav-pills">
        <li class="active"><a href="index.php">主页</a></li>
        <li><a href="index.php?module=gametest&action=set">设置</a></li>
    </ul>
    <h1>游戏测试入口</h1>
    <?php if ($_smarty_tpl->tpl_vars['tips']->value!=''){?>
    <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>
    <?php  $_smarty_tpl->tpl_vars['msg'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['msg']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tips']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['msg']->key => $_smarty_tpl->tpl_vars['msg']->value){
$_smarty_tpl->tpl_vars['msg']->_loop = true;
?>
   		 <div><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
    <?php } ?>
    </strong></div>
    <?php }?>
    <form class="form-horizontal" method="post" action="index.php">
        <table class="table table-bordered">
            <tbody id="clientList">
                 <tr><td >玩家ID</td><td><input type="text" name="pid" value="<?php echo $_smarty_tpl->tpl_vars['pid']->value;?>
"> <span style="color:blue"> * 正整数</span></td></tr>
                        <tr>
                             <td>客户端</td>
                             <td><?php if (!$_smarty_tpl->tpl_vars['clientArr']->value){?><span style="color:red">暂无选项</span><?php }else{ ?><?php  $_smarty_tpl->tpl_vars['configItem'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['configItem']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['clientArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['configItem']->key => $_smarty_tpl->tpl_vars['configItem']->value){
$_smarty_tpl->tpl_vars['configItem']->_loop = true;
?><label class="radio inline"><input type="radio" name="client" value="<?php echo $_smarty_tpl->tpl_vars['configItem']->value['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['configItem']->value['name']==$_smarty_tpl->tpl_vars['client']->value){?>checked<?php }?> ><?php if ($_smarty_tpl->tpl_vars['configItem']->value['debug']=='0'){?><span class="label label-success" style="font-size:12px"><?php }?><?php echo $_smarty_tpl->tpl_vars['configItem']->value['name'];?>
<?php if ($_smarty_tpl->tpl_vars['configItem']->value['debug']=='0'){?>(R)</span><?php }?></label><?php } ?><?php }?></td>
                        </tr>
                        <tr>
                             <td>服务端</td>
                             <td><?php if (!$_smarty_tpl->tpl_vars['serverArr']->value){?><span style="color:red">暂无选项</span><?php }else{ ?><?php  $_smarty_tpl->tpl_vars['configItem'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['configItem']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['serverArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['configItem']->key => $_smarty_tpl->tpl_vars['configItem']->value){
$_smarty_tpl->tpl_vars['configItem']->_loop = true;
?><label class="radio inline"><input type="radio" name="server" value="<?php echo $_smarty_tpl->tpl_vars['configItem']->value['name'];?>
" <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['configItem']->value['name'];?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1==$_smarty_tpl->tpl_vars['server']->value){?>checked<?php }?> ><?php echo $_smarty_tpl->tpl_vars['configItem']->value['name'];?>
</label><?php } ?><?php }?></td>
                        </tr>
                        <tr>
                             <td>自定义</td>
                             <td>
                             <div class="control-group">
<label class="control-label" for="custom_url">客户端资源地址</label>
<div class="controls">
<input type="text" name="customUrl" id="customUrl" value="<?php echo $_smarty_tpl->tpl_vars['customUrl']->value;?>
">
<span class="help-inline">如：<span style="color:blue;font-weight:bold;">http(s)://</span>10.1.1.250/client<span style="color:blue;font-weight:bold;">/</span></span>
</div>
</div>
 <div class="control-group">
                <label class="control-label">版本类型</label>
                <div class="controls">
                <label class="radio inline"><input type="radio" name="customDebug" value="1" checked >Debug版</label>
<label class="radio inline"><input type="radio" name="customDebug" value="0" <?php if ($_smarty_tpl->tpl_vars['customDebug']->value=='0'){?>checked<?php }?> >Release版</label>
                </div>
                </div>
<div class="control-group">
<label class="control-label" for="customHost">服务端地址</label>
<div class="controls">
<input type="text" name="customHost" id="customHost" value="<?php echo $_smarty_tpl->tpl_vars['customHost']->value;?>
">
<span class="help-inline">如：10.1.1.250或www.leyou.com</span>
</div>
</div>
<div>
<label class="control-label" for="customPort">服务端端口</label>
<div class="controls">
<input type="text" name="customPort" id="customPort" value="<?php echo $_smarty_tpl->tpl_vars['customPort']->value;?>
">
<span class="help-inline">如：8021</span>
</div>
</div>
</td>
                        </tr>
                        <tr>
                             <td></td>
                             <td><button name="login" class="btn btn-primary" type="submit">登录</button>
                             <button class="btn" type="reset">重置</button></td>
                        </tr>
                </tbody>
            </table>
	</form>
</div>
 <script src="resource/js/jquery.js"></script>
<script src="resource/js/bootstrap.min.js"></script>
<script src="resource/js/gametest.js"></script>
<?php if ($_smarty_tpl->tpl_vars['openWin']->value==true){?><script>window.open('index.php?action=main&s=<?php echo $_smarty_tpl->tpl_vars['s']->value;?>
','_blank');</script><?php }?>
</body>
</html><?php }} ?>