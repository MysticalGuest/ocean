<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE>
<html>
  <head>
    <base href="<%=basePath%>">
    <title>尊品360宾馆服务平台</title>
	<link rel="shortcut icon" href="img/fire.ico"  type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/fontStyle.css"/>
	<link rel="stylesheet" type="text/css" href="css/homeStyle.css"/>
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
    <style type="text/css">
	</style>
		
  </head>
  
  <body>

<div class="auto-box">
	<div class="main-box">
		<div class="index-tit">
		<div style="position:absolute; left:30%; top:3%;">
			<font style="font-family:HYChaoJiZhanJiaW;font-size:50px;color: black;">
				尊品360宾馆服务平台
			</font>
		</div>
			<h1>${thisadministrator.aName}正在运行平台！比公有云更多的，是精益求精的360°服务</h1>
			<p>千锤百炼打造面向顾客的全程服务</p>
		</div>
		<ul class="index-tserver">
			<li class="tserver-list1">
				顾客信息统计
				<p class="animated zoomin">
					<a href="administrator/CustomerInfoForAdm">查询所以已打印发票的房客基本信息</a>
				</p>
			</li>
			<li class="tserver-list2">
				前台管理
				<p class="animated zoomin">
					<a href="administrator/FrontManagement">对前台信息进行管理</a>
				</p>
			</li>
			<li class="tserver-list3">
				客房管理
				<p class="animated zoomin">
					<a href="administrator/ApartmentManageAdm">查看，更改房间状态</a>
				</p>
			</li>
			<li class="tserver-list4">
				账目管理
				<p class="animated zoomin">
					<a href="#">每日统计账目</a>
				</p>
			</li>
			<li class="tserver-list5">
				敬请期待
				<p class="animated zoomin">
					<a href="#"></a>
				</p>
			</li>
			<li class="tserver-list6">
				敬请期待
				<p class="animated zoomin">
					<a href="#"></a>
				</p>
			</li>
			<li class="tserver-list7">
				退出
				<p class="animated zoomin">
					<a href="login">回退到尊品360服务平台登录界面</a>
				</p>
			</li>
		</ul>
	</div>
	<!-- <div class="index-tserver-ad">
		<div class="main-box">
			<ul>
				<li><img src="img/tserver-ad-icon1.png">7*24*365 服务支持</li>
				<li><img src="img/tserver-ad-icon2.png">灵活定制行业解决方案</li>
				<li><img src="img/tserver-ad-icon3.png">秒级快速响应</li>
				<li><img src="img/tserver-ad-icon4.png">VVIP 大客户服务</li>
				<li><img src="img/tserver-ad-icon5.png">最高15天免费试用</li>
			</ul>
		</div>
	</div> -->
</div>

</body>
</html>

