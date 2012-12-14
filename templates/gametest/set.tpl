<!DOCTYPE html>
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
<li>
<a href="index.php">主页</a>
</li>
<li class="active"><a href="index.php?module=gametest&action=set">设置</a></li>
</ul>
<h1>服务器配置</h1>
    <ul id="navTab" class="nav nav-tabs">
        <li class="active">
        <a href="#client" id="clientNav">客户端<span>&nbsp;<span id="clientNum"><{$clientNum}></span>个</span></a>
        </li>
        <li><a href="#server" id="serverNav">服务端<span>&nbsp;<span id="serverNum"><{$serverNum}></span>个</span></a></li>
	</ul>
<div class="tab-content">
    <div class="tab-pane active" id="clientMain">
       <div><div class="btn-group"><input type="text" class="inputEmpty input-medium search-query" id="clientKeyword"></div><div class="btn-group"><button type="button" onClick="searchConfig('client')" class="btn">查找配置</button></div><div class="btn-group"><button class="btn btn-success" type="button" onClick="intoAdd('client');">添加配置</button></div><div class="btn-group"><button class="btn btn-primary" type="button" onClick="backList('client')">返回列表</button></div></div><br />
       	<div id="clientMainTips"></div>
        <table class="table table-bordered">
            <caption style="text-align:left;">配置列表：</caption>
            <thead>
                <tr>
                	<th>选择删除</th>
                    <th>排序</th>
                    <th>名称</th>
                    <th>Url地址</th>
                    <th>版本类型</th>
                    <th>操作</th>
                </tr>
        	</thead>
    		<tbody id="clientList">
            	<{if $clientArr neq ''}>
    			 <{foreach from=$clientArr item=item}>
                     <tr>
                     	 <td><input type="checkbox" name="clientNameArr" value="<{$item['name']}>" /></td>
                         <td><input style="width:42px;margin:0px;" class="clientOrder" type="text" value="<{$item['order']}>" configName="<{$item['name']}>" /></td>
                        <td><{$item['name']}></td>
                         <td><{$item['url']}></td>
                        <td><{if $item['debug'] eq '1'}>Debug版<{else}>Release版<{/if}></td>
                         <td><button class="btn" onClick="intoModify('client','<{$item['name']}>')" type="button">修改</button></td>
                    </tr>
                 <{/foreach}>
                 	<tr>
                 	<td><button class="btn btn-danger" type="button" onClick="ycDelete('client')">删除选中</button></td>
                    <td><button class="btn" type="button" onClick="order('client')">修改排序</button></td>
                    <td colspan="4"></td>
                   </tr>
                 <{/if}>
            </tbody>
		</table>
<div style="color:red" id="clientNoData"><{if !$clientArr}>暂无数据<br /><br /><{/if}></div>
	</div>
	<div class="tab-pane" id="clientAdd">
   		<div id="clientAddTips"></div>
			<form class="form-horizontal" style="overflow:hidden;">
                <fieldset><legend style="position:relative">添加客户端<button class="btn btn-primary" style="position:absolute;right:10px;bottom:5px;" type="button" onClick="backList('client')">返回列表</button></legend>
                <div class="control-group" id="clientAddNameCtrl">
                        <label class="control-label" for="clientAddName">名称</label>
                        <div class="controls">
                            <input class="inputEmpty" id="clientAddName" type="text" onKeyUp="checkName('add','client',this)" value="">
                            <span class="help-inline" ></span>
                        </div>
                    </div>
                    <div class="control-group" id="clientAddUrlCtrl">
               		 <label class="control-label" for="clientAddUrl">Url地址</label>
                    <div class="controls">
                        <input class="inputEmpty" onKeyUp="checkFormat('client','add','url',this)" id="clientAddUrl" type="text">
                        <span class="help-inline"></span>
                    </div>
               		 </div>
                    <div class="control-group">
                <label class="control-label">版本类型</label>
                
                <div class="controls">
                <label class="radio inline"><input type="radio" name="clientAddDebug" value="1" checked>Debug版</label>
<label class="radio inline"><input type="radio" name="clientAddDebug" value="0">Release版</label>
                </div>
                </div>
                 <div class="control-group" id="clientAddOrderCtrl">
               		 <label class="control-label" for="clientAddOrder">排序</label>
                    <div class="controls">
                        <input class="inputEmpty" onKeyUp="checkFormat('client','add','order',this)" id="clientAddOrder" type="text">
                        <span class="help-inline"></span>
                    </div>
               		 </div>
                    <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <button type="button" disabled='disabled' class="btn" id="clientAddSub"  onclick="add('client')">提交</button>
                </div>
             </div>
    </fieldset>
    </form>
 </div>
 <div class="tab-pane" id="clientModify">
   <div id="clientModifyTips"></div>
   <form class="form-horizontal" style="overflow:hidden;">
                <fieldset><legend style="position:relative">修改客户端<button class="btn btn-primary" style="position:absolute;right:10px;bottom:5px;" type="button" onClick="backList('client')">返回列表</button></legend>
    <div class="control-group" id="clientModifyNameCtrl">
<label class="control-label" for="clientModifyName">名称</label>
<div class="controls"><input id="clientModifyName" type="hidden">
<input id="clientModifyRename" type="text" onKeyUp="checkName('modify','client',this)" value="">
<span class="help-inline" ></span>
</div>
</div>
    <div class="control-group" id="clientModifyUrlCtrl">
<label class="control-label" for="clientModifyUrl">Url地址</label>
<div class="controls">
<input onKeyUp="checkFormat('client','modify','url',this)" id="clientModifyUrl" type="text">
<span class="help-inline"></span>
</div>
</div>
    <div class="control-group">
<label class="control-label">版本类型</label>
                <div class="controls">
                <label class="radio inline"><input type="radio" name="clientModifyDebug" value="1" checked>Debug版</label>
<label class="radio inline"><input type="radio" name="clientModifyDebug" value="0">Release版</label>
</div>
</div>
                 <div class="control-group" id="clientModifyOrderCtrl">
               		 <label class="control-label" for="clientModifyOrder">排序</label>
                    <div class="controls">
                        <input class="inputEmpty" onKeyUp="checkFormat('client','modify','order',this)" id="clientModifyOrder" type="text">
                        <span class="help-inline"></span>
                    </div>
               		 </div>
    <div class="control-group">
<label class="control-label"></label>
<div class="controls">
    <button type="button"  id="clientModifySub"  class="btn" onClick="modify('client')">提交</button>
</div>
</div>
    </fieldset>
    </form>
</div>
<div class="tab-pane" id="serverMain">
		<div><div class="btn-group"><input type="text" class="inputEmpty input-medium search-query" id="serverKeyword"></div><div class="btn-group"><button type="button" onClick="searchConfig('server')" class="btn">查找配置</button></div><div class="btn-group"><button class="btn btn-success" type="button" onClick="intoAdd('server');">添加配置</button></div><div class="btn-group"><button class="btn btn-primary" type="button" onClick="backList('server')">返回列表</button></div></div><br />
       <div id="serverMainTips"></div>
    <table class="table table-bordered">
    <caption style="text-align:left;">配置列表：</caption>
    <thead>
        <tr>
        	<th>选择</th>
            <th>排序</th>
            <th>名称</th>
            <th>主机</th>
            <th>端口</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody id="serverList"></tbody>
    </table>
            <div style="color:red" id="serverNoData"></div>
</div>
     <div class="tab-pane" id="serverAdd">
 <div id="serverAddTips"></div>
             <form class="form-horizontal" style="overflow:hidden;">
                <fieldset><legend style="position:relative">添加服务端<button class="btn btn-primary" style="position:absolute;right:10px;bottom:5px;" type="button" onClick="backList('server')">返回列表</button></legend>
    <div class="control-group" id="serverAddNameCtrl">
<label class="control-label" for="serverAddName">名称</label>
<div class="controls">
<input class="inputEmpty" id="serverAddName" type="text" onKeyUp="checkName('add','server',this)" value="">
<span class="help-inline" ></span>
</div>
</div>
    <div class="control-group" id="serverAddHostCtrl">
<label class="control-label" for="serverAddHost">主机</label>
<div class="controls">
<input class="inputEmpty" onKeyUp="checkFormat('server','add','host',this)" id="serverAddHost" type="text">
<span class="help-inline"></span>
</div>
</div>
    <div class="control-group" id="serverAddPortCtrl">
<label class="control-label" for="serverAddPost">端口</label>
<div class="controls">
<input class="inputEmpty" onKeyUp="checkFormat('server','add','port',this)" id="serverAddPost" type="text">
<span class="help-inline"></span>
</div>
</div>
            <div class="control-group" id="serverAddOrderCtrl">
               		 <label class="control-label" for="serverAddOrder">排序</label>
                    <div class="controls">
                        <input class="inputEmpty" onKeyUp="checkFormat('server','add','order',this)" id="serverAddOrder" type="text">
                        <span class="help-inline"></span>
                    </div>
               		 </div>
    <div class="control-group">
<label class="control-label"></label>
<div class="controls">
    <button type="button" class="btn"  disabled='disabled' id="serverAddSub" onclick="add('server')">提交</button>
</div>
</div>
    </fieldset>
    </form>
        </div>
<div class="tab-pane" id="serverModify">
<div id="serverModifyTips"></div>
  <form class="form-horizontal" style="overflow:hidden;">
                <fieldset><legend style="position:relative">修改服务端<button class="btn btn-primary" style="position:absolute;right:10px;bottom:5px;" type="button" onClick="backList('server')">返回列表</button></legend>
    <div class="control-group" id="serverModifyNameCtrl">
<label class="control-label" for="serverModifyName">名称</label>
<div class="controls"><input id="serverModifyName" type="hidden">
<input id="serverModifyRename" type="text" onKeyUp="checkName('modify','server',this)" value="">
<span class="help-inline" ></span>
</div>
</div>
    <div class="control-group" id="serverModifyHostCtrl">
<label class="control-label" for="serverModifyHost">主机</label>
<div class="controls">
<input onKeyUp="checkFormat('server','modify','host',this)" id="serverModifyHost" type="text">
<span class="help-inline"></span>
</div>
</div>
    <div class="control-group" id="serverModifyPostCtrl">
<label class="control-label" for="serverModifyPost">端口</label>
<div class="controls">
<input onKeyUp="checkFormat('server','modify','port',this)" id="serverModifyPost" type="text">
<span class="help-inline"></span>
</div>
</div>
      <div class="control-group" id="serverModifyOrderCtrl">
               		 <label class="control-label" for="serverModifyOrder">排序</label>
                    <div class="controls">
                        <input class="inputEmpty" onKeyUp="checkFormat('server','modify','order',this)" id="serverModifyOrder" type="text">
                        <span class="help-inline"></span>
                    </div>
               		 </div>
    <div class="control-group">
<label class="control-label"></label>
<div class="controls">
    <button type="button" class="btn"  id="serverModifySub" onclick="modify('server')">提交</button>
</div>
</div>
    </fieldset>
    </form>
</div>
	</div>
</div>
 <script src="resource/js/jquery.js"></script>
<script src="resource/js/bootstrap.min.js"></script>
<script src="resource/js/gametest.js"></script>
</body>
</html>