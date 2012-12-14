var postUrl = "index.php?module=gametest&action=api&method=";
String.prototype.trim=function()
{
     return this.replace(/(^\s*)(\s*$)/g,'');
}
var clientCheck = {'name':false,'url':false,'order':false};
var serverCheck = {'name':false,'host':false,'port':false,'order':false};
//判断json对象是否为空
function isEmptyObject(O){
	for (var x in O){
		return false;  
	}  
	return true;
}
function showModule (module){
	$('.tab-content').children().removeClass('active');
	$(module).addClass('active');
}
function showList (type,list){
	switch (type){
		case 'client' :
			$("#clientList").html(list);
			break;
		case 'server' :
			$("#serverList").html(list);
			break;
	}
}
function listHtml(type,configArr){
	list =  '';
	for(itm in configArr){
		switch (type){
			case 'client' :
				debug = configArr[itm]['debug'] == '1' ? 'Debug版':'Release版';
				list += '<tr><td><input type="checkbox" name="clientNameArr" value="'+configArr[itm]['name']+'" /></td><td><input style="width:42px;margin:0px;" class="clientOrder" type="text" value="'+configArr[itm]['order']+'" configName="'+configArr[itm]['name']+'" /></td><td>'+configArr[itm]['name']+'</td><td>'+configArr[itm]['url']+'</td><td>'+debug+'</td><td><button class="btn" onClick="intoModify(\'client\',\''+configArr[itm]['name']+'\')" type="button">修改</button></td></tr>';
				break;
			case 'server' :		
				list += '<tr><td><input type="checkbox" name="serverNameArr" value="'+configArr[itm]['name']+'" /></td><td><input style="width:42px;margin:0px;" class="serverOrder" type="text" value="'+configArr[itm]['order']+'" configName="'+configArr[itm]['name']+'" /></td><td>'+configArr[itm]['name']+'</td><td>'+configArr[itm]['host']+'</td><td>'+configArr[itm]['port']+'</td><td><button class="btn" onClick="intoModify(\'server\',\''+configArr[itm]['name']+'\')" type="button">修改</button></td></tr>';
				break;
		}
	}
	list += '<tr><td><button class="btn btn-danger" type="button" onClick="ycDelete(\''+type+'\')">删除选中</button></td><td><button class="btn" type="button" onClick="order(\''+type+'\')">修改排序</button></td><td colspan="4"></td></tr>';
	return list;
}
//成功结果提示
function successTips (str){
	var tips = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">×</button>'+str+'</div>';
	return tips;
}
function deleteTips(resultArr){
	var tips= '';
	for (itm in resultArr['success']){
		tips += '<p>'+resultArr['success'][itm]+'删除成功</p>';
	}
	return tips;
}
//警告结果提示
function errorTips (tips1){
	tips2 = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+tips1+'</strong></div>';
	return tips2;
}
//主界面提示
function mainTips (type,tips){
	switch (type){
		case 'client' :
			$("#clientMainTips").html(tips);
			break;
		case 'server' :
			$("#serverMainTips").html(tips);
			break;
	}
}
//刷新显示列表
function getList(type){
	var arr={'type':'client'};
	if(type=='server'){
		arr={'type':'server'};
	}
	$.post(postUrl+"allList",arr,function(result){
		result = eval('('+result+')');
		var list = '';
		if(result.length>0){
			list = listHtml(type,result);
		}
		$('#'+type+'NoData').html('');
		if(list===''){
			$('#'+type+'NoData').html('暂无数据<br /><br />');
		}
		showList(type,list);
	});
}
function setMainTips(type){
	if(type == 'client'){
		$('#clientMainTips').html('');
	}else if(type == 'server'){
		$('#serverMainTips').html('');
	}
}
//验证所有字段信息，返回disable
function checkAll(type){
	if(type == 'client'){
		if(clientCheck['name']&&clientCheck['url']&&clientCheck['order'])
		{
			return false;
		}
	}else{
		if(serverCheck['name']&&serverCheck['host']&&serverCheck['port']&&serverCheck['order'])
		{
			return false;
		}
	}
	return true;
}
//设置disabled
function setDisable(target,disable){
	if(disable)
	{
		$(target).attr("disabled","disabled");
	}else{
		$(target).removeAttr("disabled");
	}
}
//设置提交按钮
function setSub(type,action){
	target = '#'+type+'AddSub';
	if(action == 'modify'){
		target = '#'+type+'ModifySub';
	}
	disable = checkAll(type);
	setDisable(target,disable);
}
//名称提示
function nameTips(checkResultCode,action,name,rename){
	clientCheck['name'] = true;
	serverCheck['name'] = true;
	tips = '可以使用';
	if(checkResultCode == '0')
	{
		tips = '名称不能为空';
	}
	if(checkResultCode == '2')
	{
		tips = '名称已存在';
	}
	if(checkResultCode == '0' || checkResultCode == '2')
	{
	clientCheck['name'] = false;
	serverCheck['name'] = false;
	}
	if(action =='modify'&&name == rename)
	{
		clientCheck['name'] = true;
		serverCheck['name'] = true;
		tips = '可以使用';
	}
	return tips;
}
//格式提示
function formatTips(field,checkResultCode){
	tips = '可以使用';
	switch (field){
		case 'url' :
			clientCheck['url'] = true;
			break;
		case 'order' :
			clientCheck['order'] = true;
			serverCheck['order'] = true;
			break;
		case 'host' :
			serverCheck['host'] = true;
			break;
		case 'port' :
			serverCheck['port'] = true;
			break;
		default :
			return false;
	}
	if(checkResultCode == '3')
	{
		var formatTips = '';
		switch (field){
			case 'url' :
				clientCheck['url'] = false;
				formatTips = '（格式如：<span style="color:blue;font-weight:bold;">http(s)://</span>10.1.1.250/client<span style="color:blue;font-weight:bold;">/</span>）';
				break;
			case 'order' :
				clientCheck['order'] = false;
				serverCheck['order'] = false;
				formatTips = '（必须大于或等于0）';
				break;
			case 'host' :
				serverCheck['host'] = false;
				formatTips = '（格式如：10.1.1.250或www.leyou.com）';
				break;
			case 'port' :
				serverCheck['port'] = false;
				formatTips = '（格式如：8021）';
				break;
			default :
				return false;
		}
		tips = '格式不符'+formatTips;
	}
	return tips;
}
//设置名称提示
function setNameTips(type,action,tips){
	if(action == 'add'){
		$('#'+type+'AddNameCtrl .help-inline').html(tips);
	}else if(action == 'modify'){
		$('#'+type+'ModifyNameCtrl .help-inline').html(tips);
	}
}
//验证姓名
function checkName(action,type,target){
	arr={'value':target.value};
	$.post(postUrl+"checkName",arr,function(result){
		tips = nameTips(result,action,$('#'+type+'ModifyName').val(),target.value);
		setNameTips(type,action,tips);
		setSub(type,action);
	});
}
//验证格式
function checkFormat(type,action,field,target){
	arr={'field':field,'value':target.value};
	$.post(postUrl+"checkFormat",arr,function(result){
		switch (field){
			case 'url' :
				tips = formatTips('url',result);
				//$("#modifyUrlTips").html(tips);
				$("#clientAddUrlCtrl .help-inline").html(tips);
				$("#clientModifyUrlCtrl .help-inline").html(tips);
				break;
			case 'host' :
				tips = formatTips('host',result);
				$("#serverAddHostCtrl .help-inline").html(tips);
				$("#serverModifyHostCtrl .help-inline").html(tips);			
				break;
			case 'port' :
				tips = formatTips('port',result);
				$("#serverAddPortCtrl .help-inline").html(tips);
				$("#serverModifyPostCtrl .help-inline").html(tips);
				break;
			case 'order' :
				tips = formatTips('order',result);
				$("#clientAddOrderCtrl .help-inline").html(tips);
				$("#clientModifyOrderCtrl .help-inline").html(tips);
				$("#serverAddOrderCtrl .help-inline").html(tips);
				$("#serverModifyOrderCtrl .help-inline").html(tips);
				break;
			default:
				return false;
		}
		setSub(type,action);
	});
}
//设置总数
function setAllNum(type,num){
	switch (type){
		case 'client' :
			$('#clientNum').html(num);
			break;
		case 'server' :
			$('#serverNum').html(num);
	}
}
//返回列表
function backList(type){
	$('#clientKeyword').val('');
	$('#serverKeyword').val('');
	getList(type);
	setMainTips(type);
	if(type == 'client'){
		showModule ('#clientMain');
	}else if(type == 'server'){
		showModule ('#serverMain');
	}
}
//切换主菜单
$('#navTab a').click(function (e) {
	e.preventDefault();
	$(this).tab('show');
	$('.inputEmpty').each(function (){this.value = '';});
	
	type = 'client';
	if(this.id == 'serverNav'){
		type = 'server';
	}
	backList(type);
})
//搜索
function searchConfig(type){
		$('#'+type+'MainTips').html('');
		keyword = $('#'+type+'Keyword').val();
		keyword = keyword.trim();
		if(keyword == '')
		{
			var tips = errorTips ('搜索关键词不能为空');
			
			$('#'+type+'MainTips').html(tips);
			return;
		}
		arr={'type':type,'keyword':keyword};
		$.post(postUrl+"search",arr,function(result){

			result = eval('('+result+')');
			if(result[0]===undefined){
				
				tips = errorTips ('查无结果');
				mainTips (type,tips);
				showList (type,'');
				return ;
			}
			var list = listHtml(type,result);
			showList (type,list);
	});
}
//加入添加
function intoAdd(type){
	if(type == 'client')
	{
		$('#clientAddTips').html('');
		$("#clientAddNameCtrl .help-inline").html('');
		
		$("#clientAddUrlCtrl .help-inline").html('如：<span style="color:blue;font-weight:bold;">http(s)://</span>10.1.1.250/client<span style="color:blue;font-weight:bold;">/</span>');
		clientCheck['name'] = false;
		clientCheck['url'] = false;
		clientCheck['order'] = true;
		$('#clientAddName').val('');
		$('#clientAddUrl').val('');
	}else{
		$('#serverAddTips').html('');
		$("#serverAddNameCtrl .help-inline").html('');
		$("#serverAddHostCtrl .help-inline").html('如：10.1.1.250或www.leyou.com');
		$("#serverAddPostCtrl .help-inline").html('如：8021');
		serverCheck['name'] = false;
		serverCheck['host'] = false;
		serverCheck['port'] = false;
		serverCheck['order'] = true;
		$('#serverAddName').val('');
		$('#serverAddHost').val('');
		$('#serverAddPost').val('');
	}
	$.post(postUrl+"getMaxOrder",{'type':type},function(result){
		var maxOrder = eval('('+result+')');
		maxOrder = Number(maxOrder)+1;
		$('#clientAddOrder').val(maxOrder);
		$('#serverAddOrder').val(maxOrder);
	});
	setDisable('#'+type+'AddSub',true);
	showModule ('#'+type+'Add');
}
//添加
function add(type){
	if(type == 'client'){
		clientCheck['name'] = false;
		clientCheck['url'] = false;
		clientCheck['order'] = true;
		setDisable('#clientAddSub',true);
		
		var name = $('#clientAddName').val();
		var url = $('#clientAddUrl').val();
		var order = $('#clientAddOrder').val();
		var debug = $("input[name='clientAddDebug']:checked").val();
		var arr={'type':type,'fieldArr':{'name':name,'url':url,'debug':debug,'order':order}};
	}else if(type == 'server'){
		serverCheck['name'] = false;
		serverCheck['host'] = false;
		serverCheck['port'] = false;
		setDisable('#serverAddSub',true);
		
		var name = $('#serverAddName').val();
		var host = $('#serverAddHost').val();
		var port = $('#serverAddPost').val();
		var order = $('#serverAddOrder').val();
		var arr={'type':type,'fieldArr':{'name':name,'host':host,'port':port,'order':order}};	
	}
	$.post(postUrl+"add",arr,function(result){
		result = eval('('+result+')');
		var tips = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">×</button>';
		if (result['result']){
			tips += '<p>'+name+'添加成功</p>';
		}
		tips += '</div>';
		if(type == 'client'){
			setAllNum(type,result['totalNum']);
			$('#clientAddTips').html(tips);
		}else if(type == 'server'){
			setAllNum(type,result['totalNum']);
			$('#serverAddTips').html(tips);
		}
	});
};
//进入修改
function intoModify(type,name){
	if(type == 'client')
	{
		$('#clientModifyTips').html('');
		$("#clientModifyNameCtrl .help-inline").html('');
		$("#clientModifyOrderCtrl .help-inline").html('');
		$("#clientModifyUrlCtrl .help-inline").html('如：<span style="color:blue;font-weight:bold;">http(s)://</span>10.1.1.250/client<span style="color:blue;font-weight:bold;">/</span>');
		clientCheck['name'] = true;
		clientCheck['url'] = true;
		clientCheck['order'] = true;
		setDisable('#clientModifySub',false);
		showModule ('#clientModify');
		arr={'type':'client','name':name};
	}else if (type == 'server'){
		$('#serverModifyTips').html('');
		$("#serverModifyNameCtrl .help-inline").html('');
		$("#serverModifyOrderCtrl .help-inline").html('');
		$("#serverModifyHostCtrl .help-inline").html('如：10.1.1.250或www.leyou.com');
		$("#serverModifyPostCtrl .help-inline").html('如：8021');
		serverCheck['name'] = true;
		serverCheck['host'] = true;
		serverCheck['port'] = true;
		serverCheck['order'] = true;
		setDisable('#serverModifySub',false);
		showModule ('#serverModify');
		arr={'type':'server','name':name};
	}
	$.post(postUrl+"configInfo",arr,function(result){
		result = eval('('+result+')');
		if(isEmptyObject(result)){
			return false;
		}
		if(type == 'client')
		{
			$('#clientModifyName').val(name);
			$('#clientModifyRename').val(name);
			$('#clientModifyUrl').val(result['url']);
			$('#clientModifyOrder').val(result['order']);
			$("input[name=clientModifyDebug][value="+result['debug']+"]").attr("checked",true);
		}else if (type == 'server'){
			$('#serverModifyName').val(name);
			$('#serverModifyRename').val(name);
			$('#serverModifyOrder').val(result['order']);
			$('#serverModifyHost').val(result['host']);
			$('#serverModifyPost').val(result['port']);	
		}
	});
}
//修改
function modify(type){
	if(type == 'client'){
		clientCheck['name'] = false;
		clientCheck['url'] = false;
		clientCheck['order'] = true;
		setDisable('#clientModifySub',true);
		
		var name = $('#clientModifyName').val();
		var rename = $('#clientModifyRename').val();
		$('#clientModifyName').val(rename);
		var url = $('#clientModifyUrl').val();
		var order = $('#clientModifyOrder').val();
		var debug = $("input[name='clientModifyDebug']:checked").val();
		var arr={'type':type,'fieldArr':{'name':name,'rename':rename,'url':url,'debug':debug,'order':order}};
	}else if(type == 'server'){
		serverCheck['name'] = false;
		serverCheck['host'] = false;
		serverCheck['port'] = false;
		serverCheck['order'] = true;
		setDisable('#serverModifySub',true);
		
		var name = $('#serverModifyName').val();
		var rename = $('#serverModifyRename').val();
		$('#serverModifyName').val(rename);
		var host = $('#serverModifyHost').val();
		var port = $('#serverModifyPost').val();
		var order = $('#serverModifyOrder').val();
		var arr={'type':type,'fieldArr':{'name':name,'rename':rename,'host':host,'port':port,'order':order}};
	}
	$.post(postUrl+"modify",arr,function(result){
		var tips = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">×</button>';
		if(result == 'true'){
			tips += '<p>'+name+'修改成功</p>';
		}
		tips += '</div>';
		if(type == 'client'){
			$('#clientModifyTips').html(tips);
		}else if(type == 'server'){
			$('#serverModifyTips').html(tips);
		}
	});
};
//删除选中
function ycDelete(type){
	var selectedNum = $("input[name='"+type+"NameArr']:checked").length;
	if(selectedNum>0){
		var ifDel= window.confirm("单击'确定'继续。单击'取消'停止。");
		if (ifDel) {
			nameArr=[];
			i=0;
			$($("input[name='"+type+"NameArr']:checked")).each(
				function(){
					nameArr[i]=this.value;
					i++;
				}
			);
			$.post(postUrl+"delete",{'type':type,'nameArr':nameArr},function(result){
				result = eval('('+result+')');
				var str = deleteTips(result);
				var tips = successTips (str);
				setAllNum(type,result['totalNum']);
				var keyword = $('#'+type+'Keyword').val();
				keyword = keyword.trim();
				if(keyword != '')
				{
					var arr={'type':type,'keyword':keyword};
					$.post(postUrl+"search",arr,function(result){
						result = eval('('+result+')');
						if(result[0]===undefined){
							tips += errorTips ('查无结果');
							mainTips (type,tips);
							showList (type,'');
							return ;
						}
						mainTips (type,tips);
						var list = listHtml(type,result);
						showList (type,list);
					});
					return;
				}
				mainTips (type,tips);
				getList(type);
			});
		}
	}else{
		tips = errorTips ('请先选择');
		$('#'+type+'MainTips').html(tips);
	}
}

//排序
function order(type){
	var arr = {'type':type,'orderArr':{}};
	$('.'+type+'Order').each(function (){
		arr['orderArr'][$(this).attr('configName')] = $(this).attr('value');
	});
	$.post(postUrl+"order",arr,function(data){
		data = eval('('+data+')');
		if(data['modifyNum'] == 0){
			errorStr = errorTips ('排序没有更改');
			mainTips (type,errorStr);
			return;
		}
		if(data['err'].length!==0){
			var errorStr ='';
			for(var itm in data['err']){
				errorStr += '<p>"'+itm+'"的序号"'+data['err'][itm]+'"不是自然数</p>';
			}
			errorStr = errorTips (errorStr);
			mainTips (type,errorStr);
			return ;
		}
		if(data['modifyNum'] >= 0){
			var successStr = successTips('修改排序完成');
			mainTips (type,successStr);
			var list = listHtml(type,data['allList']);
			$('#'+type+'NoData').html('');
			if(list===''){
				$('#'+type+'NoData').html('暂无数据<br /><br />');
			}
			showList(type,list);
		}
	});
}

$('.inputEmpty').each(function (){this.value = '';});