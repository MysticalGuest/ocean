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
	<link rel="shortcut icon" href="img/fbadge.ico"  type="image/x-icon"/>
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
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <style type="text/css">
	</style>
		
  </head>
  
<body style="background-image : url(img/background.jpg);background-repeat : no-repeat;background-size:100% 100%; background-attachment: fixed;">
	<div style="position:absolute; left:25%; top:47%;">
		<font style="font-family: YouYuan, helvetica, sans-serif;font-size:50px;color: black;">
			360宾馆服务平台
		</font>
	</div>
	<div style="position:absolute; left:23%; top:25%;">
		<img src="img/3601.png" width="50%">
	</div>
	<div style="position:absolute; left:66%; top:26%;">
		<font size="5%" face="STHeiTI" color="black">账号登录</font>
	</div>
	<div style="position:absolute; left:62.5%; top:38%;">
		<img src="img/图标1.png" width="6%">
	</div>
	<div style="position:absolute; left:62.4%; top:46%;">
		<img src="img/图标2.png" width="6%">
	</div>
	<div style="position:absolute; left:62.3%; top:54%;">
		<img src="img/图标3.png" width="6%">
	</div>
	<form id="LoginForm" onsubmit="return login();" action="login" method="post">
		<div style="position:absolute; left:65%; top:38%;">
            <input class="easyui-textbox" name="AdmId" style="width:170px;height:30px;padding:10px;border-radius:3px; border:1px solid grey;" placeholder="用户名">
        </div>
		<div style="position:absolute; left:65%; top:46%;">
            <input class="easyui-passwordbox" name="aPassword" style="width:170px;height:30px;padding:10px;border-radius:3px; border:1px solid grey;" placeholder="密码">
        </div>
		<div style="position:absolute; left:65%; top:54%;">
			<div style="float: left;">
				<input class="easyui-radiobutton" name="limits" value="front" label="前台:" labelWidth="40" checked="checked">
			</div>
			<div style="float: right;padding-left: 25px;">
				<input class="easyui-radiobutton" name="limits" value="administrator" label="管理员:" labelWidth="50">
			</div>
		</div>
		<div style="position:absolute; left:65%; top:62%;">
			<input type="submit" value="登录" style="width:160px;height:35px;border-radius:3px; border:1px grey; background-color: grey; color:white;cursor:pointer;">
		</div>
		<div id="demo" style="position:absolute; left:65%; top:58%;color:red;font-size: 75%;"></div>
		<script type="text/javascript">
			function login() {
				var Id=document.forms["LoginForm"]["AdmId"].value;
				var password=document.forms["LoginForm"]["aPassword"].value;
				if(Id==""||Id==null){
					document.getElementById("demo").innerHTML = "请输入用户名！";
					return false;
				}
				else if(password==""||Id==null){
					document.getElementById("demo").innerHTML = "请输入密码！";
					return false;
				}
				else{
				    return true;
				}
				
			}
		</script>
	</form>

</body>
  
</body>
</html>
