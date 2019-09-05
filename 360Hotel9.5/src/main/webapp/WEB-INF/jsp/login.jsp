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
			.styled-input .fa{
			    position: absolute;
			    right: 10px;
			    top:5px;
			    font-size: 20px;
			    cursor: pointer;
			}
		    .fa-eye-slash{
		        margin-top: 6px;
		        margin-left: 7px;
		        width: 20px;
		        height: 20px;
		        background-image: url(img/eye-slash.png);
		        background-repeat: no-repeat;
		        background-size: 20px 17px;
		    }
		    .fa-eye{
		        margin-top: 6px;
		        width: 20px;
		        margin-left: 7px;
		        height: 20px;
		        background-image: url(img/eye.png);
		        background-repeat: no-repeat;
		        background-size: 20px 17px;
		
		    }
		</style>
		<title></title>
	</head>
	<body style="background-image : url(img/background.jpg);background-repeat : no-repeat;background-size:100% 100%; background-attachment: fixed;">
		<div style="position:absolute; left:40%; top:10%;">
			<font style="font-family:HYChaoJiZhanJiaW;font-size:50px;color: black;">
				尊品360宾馆服务平台
			</font>
		</div>
		<div style="position:absolute; left:18%; top:8%;">
			<img src="img/360.png" width="65%">
		</div>
		<div style="position:absolute; left:12%; top:41%;">
			<img src="img/图标1.png" width="7%">
		</div>
		<div style="position:absolute; left:12%; top:51%;">
			<img src="img/图标2.png" width="7%">
		</div>
		<div style="position:absolute; left:12%; top:61%;">
			<img src="img/图标3.png" width="4%">
		</div>
		<form class="form" id="LoginForm" onsubmit="return login();" action="login" method="post">
			<div class="form__content">
				<h1>账号登录</h1>
				<div class="styled-input">
					<input type="text" class="styled-input__input" name="AdmId">
					<div class="styled-input__placeholder"> <span class="styled-input__placeholder-text">账号</span> </div>
					<div class="styled-input__circle"></div>
				</div>
				<div class="styled-input">
					<input type="password" class="styled-input__input" name="aPassword" ><i class="fa fa-eye-slash"></i>
					<div class="styled-input__placeholder"> <span class="styled-input__placeholder-text">密码</span> </div>
					<div class="styled-input__circle"></div>
				</div>
				<div style="float: left;">
					<input class="easyui-radiobutton" name="limits" value="front" checked="checked" label="前台:" labelWidth="40">
				</div>
				<div style="padding-left: 20px;">
					<input class="easyui-radiobutton" name="limits" value="administrator" label="管理员:" labelWidth="50">
				</div>
				<div id="demo" style="position:absolute; left:22%; top:60%;color:orange;font-size: 75%;"></div>
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
				<button type="submit" class="styled-button">
					<span class="styled-button__real-text-holder">
						<span class="styled-button__real-text">登 录</span>
						<span class="styled-button__moving-block face">
							<span class="styled-button__text-holder">
								<span class="styled-button__text">登 录</span>
							</span>
						</span>
						<span class="styled-button__moving-block back">
							<span class="styled-button__text-holder">
								<span class="styled-button__text">登 录</span>
							</span>
						</span>
					</span>
				</button>
			</div>
		</form>
		<script type="text/javascript">
		    $(".styled-input").on("click", ".fa-eye-slash", function () {
		        $(this).removeClass("fa-eye-slash").addClass("fa-eye");
		        $(this).prev().attr("type", "text");
		    });
		     
		    $(".styled-input").on("click", ".fa-eye", function () {
		        $(this).removeClass("fa-eye").addClass("fa-eye-slash");
		        $(this).prev().attr("type", "password");
		    });
		</script>
		<script  src="js/login.js"></script>
	</body>
</html>
