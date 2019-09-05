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
   		<form class="form" id="searchForm" action="/administrator/CustomerInfoForFront" method="post">
			<div id="search" style="padding:3px;background-color: #00B4FA;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;">
				<input id="datetime" name="datetime" class="easyui-datetimebox"
				style="border:1px solid #ccc;border-radius: 5px;" data-options="prompt:'根据入住时间查询:'"></input>
			</div>
			<div id="search" style="padding:3px;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
				<input id="cName" name="cName" class="easyui-textbox"
				style="border:1px solid #ccc;border-radius: 5px;" data-options="prompt:'根据房客姓名查询:'"></input>
			</div>
			<div id="search" style="padding:3px;background-color: #00B4FA;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
				<input id="roomNum" name="roomNum" class="easyui-textbox"
				style="border:1px solid #ccc;border-radius: 5px;" data-options="prompt:'根据入住房间查询:'"></input>
			</div>
			<div id="search" style="padding:3px;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
				<button class="easyui-linkbutton" iconCls="icon-search" type="submit" style="width: 95%;">搜索</button>
			</div>
		</form>
		<div id="search" style="padding:3px;background-color: #00B4FA;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
			<button class="easyui-linkbutton" onclick="showAll()" style="width: 95%;">显示全部</button>
		</div>
		<script>
			//显示全部调用函数
			function showAll(){
				var datetime="";
				var cName="";
				var roomNum="";
				$.ajax({
			       	url: '../administrator/CustomerInfoForFront',
			       	type: 'post',
			       	data: {'datetime':datetime,'cName':cName,'roomNum':roomNum},
			       	traditional:true,//用传统方式序列化数据
			       	success:function(){
			        	$.messager.alert('提示','全部顾客信息显示成功！','info',
			        		function(){
								location.href='../administrator/CustomerInfoForFront'
							}
			        	)          
			       	}
			   	});
			}
		</script>
	</div>
	<!--东-->
	<div data-options="region:'east',border:false," style="background:#fff;width:20%;" >
		<div class="main-box">
			<ul class="index-tserver">
				<li class="tserver-list1">
					返回首页
					<p class="animated zoomin">
						<a href="administrator/Home">返回首页，执行其他选项操作</a>
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
   	<div data-options="region:'center',border:true,title:'顾客信息'" style="background:#fff;" >
   		<div style="width:100%;height:100%;float: right;padding: 5px;">
   			<table id="dg" class="easyui-datagrid" style="width:100%;height:100%"
   				fitColumns="true" data-options="
					rownumbers:true,
					singleSelect:true,
					autoRowHeight:true,
					pagination:true,
					pageSize:10">
				<thead>
					<tr>
						<th field="CustomerId" width="20" align="center">序号</th>
						<th field="inTime" align="center">入住时间</th>
						<th field="cName" width="40" align="center">姓名</th>
						<th field="cardID" align="center">身份证号</th>
						<th field="cSex" width="20" align="center">性别</th>
						<th field="roomNum" width="60" align="center" formatter="linefeed" >房号</th>
					</tr>
				</thead>
			</table>
			
			<script>
				//对‘房间’列换行
				function linefeed(value,row,index) {
				    return "<div style='width=250px;word-break:break-all;word-wrap:break-word;white-space:pre-wrap;'>"
				    +value+"</div>";
				}
				function getData(){
					var rows = [];
					var jsondata='<%=session.getAttribute("jsonCustomer")%>';
					data= JSON.parse(jsondata);
					for(var i=0; i<data.length; i++){
						rows.push({
							CustomerId: data[i].customerId,
							inTime: data[i].inTime,
							cName: data[i].cName,
							cardID: data[i].cardID,
							cSex: data[i].cSex,
							roomNum: data[i].roomNum,
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
