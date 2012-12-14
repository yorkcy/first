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
        <li class="active"><a href="index.php">主页</a></li>
        <li><a href="index.php?module=gametest&action=set">设置</a></li>
    </ul>
    <h1>游戏测试入口</h1>
    <{if $tips neq ''}>
    <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>
    <{foreach from=$tips item=msg}>
   		 <div><{$msg}></div>
    <{/foreach}>
    </strong></div>
    <{/if}>
    <form class="form-horizontal" method="post" action="index.php">
        <table class="table table-bordered">
            <tbody id="clientList">
                 <tr><td >玩家ID</td><td><input type="text" name="pid" value="<{$pid}>"> <span style="color:blue"> * 正整数</span></td></tr>
                        <tr>
                             <td>客户端</td>
                             <td><{if !$clientArr}><span style="color:red">暂无选项</span><{else}><{foreach from=$clientArr item=configItem}><label class="radio inline"><input type="radio" name="client" value="<{$configItem['name']}>" <{if $configItem['name'] eq $client}>checked<{/if}> ><{if $configItem['debug'] eq '0'}><span class="label label-success" style="font-size:12px"><{/if}><{$configItem['name']}><{if $configItem['debug'] eq '0'}>(R)</span><{/if}></label><{/foreach}><{/if}></td>
                        </tr>
                        <tr>
                             <td>服务端</td>
                             <td><{if !$serverArr}><span style="color:red">暂无选项</span><{else}><{foreach from=$serverArr item=configItem}><label class="radio inline"><input type="radio" name="server" value="<{$configItem['name']}>" <{if <{$configItem['name']}> eq $server}>checked<{/if}> ><{$configItem['name']}></label><{/foreach}><{/if}></td>
                        </tr>
                        <tr>
                             <td>自定义</td>
                             <td>
                             <div class="control-group">
<label class="control-label" for="custom_url">客户端资源地址</label>
<div class="controls">
<input type="text" name="customUrl" id="customUrl" value="<{$customUrl}>">
<span class="help-inline">如：<span style="color:blue;font-weight:bold;">http(s)://</span>10.1.1.250/client<span style="color:blue;font-weight:bold;">/</span></span>
</div>
</div>
 <div class="control-group">
                <label class="control-label">版本类型</label>
                <div class="controls">
                <label class="radio inline"><input type="radio" name="customDebug" value="1" checked >Debug版</label>
<label class="radio inline"><input type="radio" name="customDebug" value="0" <{if $customDebug eq '0'}>checked<{/if}> >Release版</label>
                </div>
                </div>
<div class="control-group">
<label class="control-label" for="customHost">服务端地址</label>
<div class="controls">
<input type="text" name="customHost" id="customHost" value="<{$customHost}>">
<span class="help-inline">如：10.1.1.250或www.leyou.com</span>
</div>
</div>
<div>
<label class="control-label" for="customPort">服务端端口</label>
<div class="controls">
<input type="text" name="customPort" id="customPort" value="<{$customPort}>">
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
<{if $openWin eq true}><script>window.open('index.php?action=main&s=<{$s}>','_blank');</script><{/if}>
</body>
</html>