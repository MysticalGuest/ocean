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
		div.a2:hover{background-color: #eaf2ff}
		div.a3:hover{background-color: #eaf2ff}
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
				<div class="a1" style="top:5%;padding: 8%;border-radius:10px; border:1px solid rgba(0,0,0,0);
					text-align:center;background-color: #ffe48d;">
					<a style="text-decoration: none;" href="../administrator/FrontManagement"><font size="5%" face="STHeiTI">前台管理</font></a>
				</div>
				<div class="a2" style="top:15%;padding: 8%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style="text-decoration: none;" href="../administrator/CustomerInfoForAdm"><font size="5%" face="STHeiTI">顾客信息</font></a>
				</div>
				<div class="a3" style="top:25%;padding: 8%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style="text-decoration: none;" href="../administrator/ApartmentManageAdm"><font size="5%" face="STHeiTI">客房管理</font></a>
				</div>
			</div>
    	</div>
    	
    	<!--中-->
    	<div data-options="region:'center',border:true,title:'前台管理'" style="background:#fff;" >
    		<div style="width:100%;height:100%;float: right;padding: 5px;">
    			<table id="dg" class="easyui-datagrid" style="width:100%;height:100%"
    				fitColumns="true" data-options="
						rownumbers:true,
						singleSelect:true,
						autoRowHeight:false,
						pagination:true,
						pageSize:10">
					<thead>
						<tr>
							<th field="admId" width="50" align="center">编号</th>
							<th field="aName" width="50" align="center">姓名</th>
							<th field="aPassword" width="50" align="center">密码</th>
							<th field="aSex" width="50" align="center">性别</th>
							<th field="limit" width="50" align="center">权限</th>
						</tr>
					</thead>
				</table>
				
				<script>
					function getData(){
						var rows = [];
						var jsondata='<%=session.getAttribute("json")%>';
						data= JSON.parse(jsondata);
						var limit="";
						for(var i=0; i<data.length; i++){
							rows.push({
								admId: data[i].admId,
								aName: data[i].aName,
								aPassword: data[i].aPassword,
								aSex: data[i].aSex,
								limit: limit,
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
						$('#dg').datagrid({loadFilter:pagerFilter}).datagrid('loadData', getData());
					});
				</script>
			</div>
    	</div>
</body>
</html>
