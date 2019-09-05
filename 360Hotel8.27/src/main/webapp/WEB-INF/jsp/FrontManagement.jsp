<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE HTML>
<html>
  <head>
    <base href="<%=basePath%>">
    
    <meta http-equiv="content-type" content="text/html" charset="utf-8">
	<title>尊品360宾馆管理系统</title>
	<link rel="shortcut icon" href="img/fire.ico"  type="image/x-icon"/>
    
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<link rel="stylesheet" type="text/css" href="css/fontStyle.css"/>
	<link rel="stylesheet" type="text/css" href="css/CustomerInfoStyle.css"/>
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="easyui/locale/easyui-lang-zh_CN.js"></script>
  </head>
  <body class="easyui-layout">
   	<!--上-->
 	<div data-options="region:'north',border:false," style="background:#fff;height:20%;" >
		<div style="position:absolute; left:45%; top:20%;">
			<font style="font-family:HYChaoJiZhanJiaW;font-size:50px;color: black;">
				尊品360宾馆服务平台
			</font>
		</div>
		<div style="position:absolute; left:18%; top:8%;">
			<img src="img/360black.png" width="65%">
		</div>
	</div>
 	<!--西-->
   	<div data-options="region:'west',border:false," style="background:#fff;width:20%;" >
		<div id="search" style="padding:3px;background-color: #00B4FA;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;">
			<input id="cardIdQuery" name="cardIdQuery" class="easyui-textbox" 
			style="border:1px solid #ccc;border-radius: 5px;" data-options="prompt:'待定:'"></input>
		</div>
		<div id="search" style="padding:3px;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
			<button class="easyui-linkbutton" onclick="" style="width: 95%;">待定</button>
		</div>
	</div>
	<!--东-->
	<div data-options="region:'east',border:false," style="background:#fff;width:20%;" >
		<div class="main-box">
			<ul class="index-tserver">
				<li class="tserver-list1">
					返回首页
					<p class="animated zoomin">
						<a href="administrator/HomeForAdm">返回首页，执行其他选项操作</a>
					</p>
				</li>
				<li class="tserver-list2">
					敬请期待
					<p class="animated zoomin">
						<a href="#"></a>
					</p>
				</li>
			</ul>
		</div>
	</div>
    	
   	<!--中-->
   	<div data-options="region:'center',border:true,title:'前台管理'" style="background:#fff;" >
   		<div style="width:100%;height:100%;float: right;padding: 5px;">
   			<table id="front" class="easyui-datagrid" style="width:100%;height:100%"
   				fitColumns="true" idField="admId" data-options="
					rownumbers:true,
					singleSelect:true,
					autoRowHeight:false,
					pagination:true,
					pageSize:10">
				<thead>
					<tr>
						<th field="admId" width="50" align="center">账号</th>
						<th field="aName" width="50" align="center" editor="{type:'textbox',options:{required: true}}">姓名</th>
						<th field="aPassword" width="50" align="center" editor="{type:'textbox',options:{required: true}}">密码</th>
						<th field="aSex" width="50" align="center" formatter="formatSex">性别</th>
						<th field="action" width="50" align="center" formatter="formatAction">修改</th>
					</tr>
				</thead>
			</table>
			
			<script type="text/javascript">
				function formatSex(value,row,index) {
					var jsondata='<%=session.getAttribute("json")%>';
					data= JSON.parse(jsondata);
                    if (row.editing) {
                        var s = '男<input name="sex" type="radio" checked="checked" value="man"/> '+
                        '女<input name="sex" type="radio" value="woman"/>';
                    }
                    else {
	                    for(var i=0; i<data.length; i++){
	                    	if(row.admId==data[i].admId){
	                    		var s=data[i].aSex;
	                    		break;
	                    	}
						}
                    }
                    return s;
                }
				function formatAction(value,row,index){
					if (row.editing){
						var save = '<button onclick="saverow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">保存</button> ';
						var cancel = '<button onclick="cancelrow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">取消</button>';
						return save+cancel;
					} else {
						var edit = '<button onclick="editrow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">编辑</button> ';
						return edit;
					}
					
				}
				
				$(function(){
					$('#front').datagrid({
						onBeforeEdit:function(index,row){
							$(this).datagrid('updateRow', {index:index,row:{editing:true}})
						},
						onAfterEdit:function(index,row){
							$(this).datagrid('updateRow', {index:index,row:{editing:false}})
						},
						onCancelEdit:function(index,row){
							$(this).datagrid('updateRow', {index:index,row:{editing:false}})
						}
					});
				});
				function getRowIndex(target){
					var tr = $(target).closest('tr.datagrid-row');
					return parseInt(tr.attr('datagrid-row-index'));
				}
				function editrow(target){
					$('#front').datagrid('beginEdit', getRowIndex(target));
				}
				
				function saverow(target){
					var selectSex=$("input[name='sex']:checked").val();//必须放在第一句
					
					$('#front').datagrid('endEdit', getRowIndex(target));
					var row = $('#front').datagrid('getSelected');
					var admId=row.admId;
					var aName=row.aName;
					var aPassword=row.aPassword;
					if (row){
						$.ajax({
	                    	url: '../administrator/ResetAdmInfo',
	                    	type: 'post',
	                    	data: {'admId':admId,'aName':aName,'aPassword':aPassword,'aSex':selectSex},
	                    	traditional:true,//用传统方式序列化数据
	                    	success:function(){
		                    	$.messager.alert('提示','修改成功！','info',
		                    		function(){
										location.href='../administrator/FrontManagement'
									}
		                    	)             
	                    	}
	                	});
					}
				}
				function cancelrow(target){
					$('#front').datagrid('cancelEdit', getRowIndex(target));
				}
				$('#front').datagrid('selectRow',index);
				$('#front').datagrid('beginEdit',index);
			</script>
				
			<script>
				function getData(){
					var rows = [];
					var jsondata='<%=session.getAttribute("json")%>';
					data= JSON.parse(jsondata);
					for(var i=0; i<data.length; i++){
						rows.push({
							admId: data[i].admId,
							aName: data[i].aName,
							aPassword: data[i].aPassword,
						});
					}
					return rows;
				}
	
				function pagerFilter(data){
					if (typeof data.length == 'number' && typeof data.splice == 'function'){	// is array
						data = {
							total: data.length,
							rows: data
						}
					}
					var dg = $(this);
					var opts = dg.datagrid('options');
					var pager = dg.datagrid('getPager');
					pager.pagination({
						onSelectPage:function(pageNum, pageSize){
							opts.pageNumber = pageNum;
							opts.pageSize = pageSize;
							pager.pagination('refresh',{
								pageNumber:pageNum,
								pageSize:pageSize
							});
							dg.datagrid('loadData',data);
						}
					});
					if (!data.originalRows){
						data.originalRows = (data.rows);
					}
					var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
					var end = start + parseInt(opts.pageSize);
					data.rows = (data.originalRows.slice(start, end));
					return data;
				}
	
				$(function(){
					$('#front').datagrid({loadFilter:pagerFilter}).datagrid('loadData', getData());
				});
			</script>
		</div>
   	</div>
</body>
</html>
