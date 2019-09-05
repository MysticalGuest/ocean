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
	<link rel="shortcut icon" href="img/fbadge.ico"  type="image/x-icon"/>
    
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="easyui/locale/easyui-lang-zh_CN.js"></script>
	
	<style type="text/css">
		a:link {color: black}
		a:visited {color: black}
		a:hover {color:grey}
		a:active {color: black}
		div.a1:hover{background-color: #eaf2ff}
		div.a2:hover{background-color: #eaf2ff}
		div.a4:hover{background-color: #eaf2ff}
		div.a5:hover{background-color: #eaf2ff}
		div.a6:hover{background-color: #eaf2ff}
	</style>
	<style type="text/css">
		a.a:link {color: white}
		a.a:visited {color: white}
		a.a:hover {color:grey}
		a.a:active {color: white}
	</style>

  </head>
  
  <body class="easyui-layout">
  	<!--上-->
 	<div data-options="region:'north',border:false,split:false,collapsible:false" style="height:20%;background-color: #262D35;">
		<img  src="img/badgewhite.png" style="width: 60px;height: 60px;margin:20px;float: left;">
		<img src="img/exit.png" style="position: absolute;right:7%;top:60%;height: 35px;width: 35px;">
		<font class="SystemFont">360宾馆管理系统</font>
		<a class="a" href="login" style="right: 2%;top: 60%;text-decoration: none;position: absolute;">
			<font style="font-family: YouYuan, helvetica, sans-serif;font-size: 30px;">退出</font>
		</a> 
		<font class="welcomeFont" style="float: right;">您好！${thisadministrator.aName}！欢迎登录！</font>
 	</div>
 	<!--西-->
   	<div data-options="region:'west',border:true,split:false,collapsible:false" 
   		style="width:15%; background-color: #f8f8f8; border:2px solid grey;">
   		<div style="position:absolute;left:12.5%;width: 75%;top:5%;">
			<div class="a1" style="top:5%;padding: 8%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
				<a style="text-decoration: none;" href="../administrator/FrontManagement"><font size="5%" face="STHeiTI">前台管理</font></a>
			</div>
			<div class="a2" style="top:15%;padding: 8%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
				<a style="text-decoration: none;" href="../administrator/CustomerInfoForAdm"><font size="5%" face="STHeiTI">顾客信息</font></a>
			</div>
			<div class="a3" style="top:25%;padding: 8%;border-radius:10px; border:1px solid rgba(0,0,0,0);
			text-align:center;background-color: #ffe48d;">
				<a style="text-decoration: none;" href="../administrator/ApartmentManageAdm"><font size="5%" face="STHeiTI">客房管理</font></a>
			</div>
		</div>
   	</div>
   	
   	<!--中-->
   	<div data-options="region:'center',border:true,title:'客房管理'" style="background:#fff;" >
   		<div style="width:100%;height:100%;float: right;padding: 5px;">
   			<table id="apartment" class="easyui-datagrid" style="width:100%;height:100%"
   				fitColumns="true" idField="roomNum" data-options="
					rownumbers:true,
					autoRowHeight:true,
					pagination:true,
					pageSize:10">
				<thead>
					<tr>
						<th field="ck" checkbox="true"></th>
						<th field="roomNum" width="50" align="center">房号</th>
						<th field="price" width="50" align="center" editor="numberbox">价格</th>
						<th field="state" width="50" align="center" editor="{type:'checkbox',options:{on:'已开出',off:'未开出'}}">房间状态</th>
						<th field="action" width="50" align="center" formatter="formatAction">修改</th>
						
					</tr>
				</thead>
			</table>
			
			<script type="text/javascript">
				function formatAction(value,row,index){
					if (row.editing){
						var save = '<button onclick="saverow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">保存</button> ';
						var cancel = '<button onclick="cancelrow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">取消</button>';
						return save+cancel;
					} else {
						var edit = '<button onclick="editrow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">编辑</button> ';
						var checkOut = '<button onclick="checkOut(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">退房</button>';
						if(row.state=="未开出")
							return edit;
						else if(row.state=="已开出")
							return edit+checkOut;
					}
					
				}
				
				$(function(){
					$('#apartment').datagrid({
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
					$('#apartment').datagrid('beginEdit', getRowIndex(target));
				}
				function checkOut(target){
					var flag="adm";
					var row = $('#apartment').datagrid('getSelected');
					var roomNum=row.roomNum;
					if (row){
						$.ajax({
	                    	url: '../administrator/checkOut',
	                    	type: 'post',
	                    	data: {'roomNum':roomNum,'flag':flag},
	                    	traditional:true,//用传统方式序列化数据
	                    	success:function(){
		                    	$.messager.alert('提示','退房成功！','info',
		                    		function(){
										location.href='../administrator/ApartmentManageAdm'
									}
		                    	)             
	                    	}
	                	});
					}
				}
				function saverow(target){
					$('#apartment').datagrid('endEdit', getRowIndex(target));
					var row = $('#apartment').datagrid('getSelected');
					var price=row.price;
					var roomNum=row.roomNum;
					if (row){
						$.ajax({
	                    	url: '../administrator/ResetPrice',
	                    	type: 'post',
	                    	data: {'roomNum':roomNum,'price':price},
	                    	traditional:true,//用传统方式序列化数据
	                    	success:function(){
		                    	$.messager.alert('提示','修改成功！','info',
		                    		function(){
										location.href='../administrator/ApartmentManageAdm'
									}
		                    	)             
	                    	}
	                	});
					}
				}
				function cancelrow(target){
					$('#apartment').datagrid('cancelEdit', getRowIndex(target));
				}
				$('#apartment').datagrid('selectRow',index);
				$('#apartment').datagrid('beginEdit',index);
			</script>
			
			<script>
				function getData(){
					var state='';
					var rows = [];
					var jsondata='<%=session.getAttribute("jsonROOM")%>';
					data= JSON.parse(jsondata);
					for(var i=0; i<data.length; i++){
						if(data[i].state==false)
							state="未开出";
						else if(data[i].state==true)
							state="已开出";
						rows.push({
							roomNum: data[i].roomNum,
							price: data[i].price,
							state: state,
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
					$('#apartment').datagrid({loadFilter:pagerFilter}).datagrid('loadData', getData());
				});
			</script>
		</div>
   	</div>
   	
  </body>
</html>
