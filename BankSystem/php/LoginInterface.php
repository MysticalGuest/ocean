<?php session_start(); ?>
	
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>银行系统服务平台</title>
		<link rel="shortcut icon" href="../img/fbadge.ico"  type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="../easyui/themes/default/easyui.css">
		<link rel="stylesheet" type="text/css" href="../easyui/themes/icon.css">
		<link rel="stylesheet" type="text/css" href="../easyui/demo/demo.css">
		<script type="text/javascript" src="../easyui/jquery.min.js"></script>
		<script type="text/javascript" src="../easyui/jquery.easyui.min.js"></script>
		
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
	</head>
	<body style="background-image : url(../img/背景图片.jpg);background-repeat : no-repeat;background-size:100% 100%; background-attachment: fixed;">
		<div style="position:absolute; left:27%; top:47%;">
			<font style="font-family: YouYuan, helvetica, sans-serif;font-size: 40px;color: black;">
				银行系统服务平台
			</font>
		</div>
		<div style="position:absolute; left:23%; top:25%;">
			<img src="../img/badgeblack.png" width="25%">
		</div>
		<div style="position:absolute; left:66%; top:26%;">
			<font size="5%" face="STHeiTI" color="grey">账号登录</font>
		</div>
		<div style="position:absolute; left:62.5%; top:38%;">
			<img src="../img/图标1.png" width="6%">
		</div>
		<div style="position:absolute; left:62.4%; top:46%;">
			<img src="../img/图标2.png" width="6%">
		</div>
		<div style="position:absolute; left:62.3%; top:54%;">
			<img src="../img/图标3.png" width="6%">
		</div>
		<!--<div id="demo" style="position:absolute; left:65%; top:58%;color:red;font-size: 75%;"></div>-->
		<form id="loginForm" onsubmit="return validateLogin();" action="LoginInterface.php" method="post">
			<div style="position:absolute; left:65%; top:38%;">
	            <input class="easyui-textbox"  name="cardId" style="width:170px;height:30px;padding:10px;border-radius:3px; border:1px solid grey;"></input>
	        </div>
			<div style="position:absolute; left:65%; top:46%;">
	            <input class="easyui-passwordbox" name="upassword" style="width:170px;height:30px;padding:10px;border-radius:3px; border:1px solid grey;"></input>
	        </div>
	        <div style="position:absolute; left:65%; top:54%;">
				<div style="float: left;">
					<input class="easyui-radiobutton" checked="checked"  name="limits" value="user" label="用户:" labelWidth="40"></input>
				</div>
				<div style="float: right;padding-left: 25px;">
					<input class="easyui-radiobutton" name="limits" value="manager" label="管理员:" labelWidth="50"></input>
				</div>
			</div>
			<!--<div id="demo" style="position:absolute; left:65%; top:58%;color:red;font-size: 75%;"></div>-->
			<div style="position:absolute; left:65%; top:62%;">
				<button style="width:80px;height:35px;
					border-radius:3px; border:1px grey; background-color: grey; color:white;cursor:pointer;float: left;">登录</button>
			</div>
			<script>
				function validateLogin() {
					var cardId=document.forms["loginForm"]["cardId"].value;
					var upassword=document.forms["loginForm"]["upassword"].value;
					if(cardId==null || cardId==""){
						$.messager.alert('提示', '请填写账号！');
						return false;
					}
					else if(upassword=="" || upassword==null){
						$.messager.alert('提示', '请输入密码！');
						return false;
					}
				}
			</script>
		</form>
		<div style="position:absolute; left:71%; top:62%;">
			<button onclick="javascript:window.location.href='RtrievePassword.php'" style="width:80px;height:35px;
				border-radius:3px; border:1px grey; background-color: grey; color:white;cursor:pointer;float: right;">
				密码找回
			</button>
		</div>
	</body>
</html>

<?php
	$servername = "localhost";
	$username = "root";
	$password = "Bestwich1314";
	$database = "bank";
 
	// 创建连接
	$conn = new mysqli($servername, $username, $password, $database);
	mysqli_query($conn,"set names utf8"); 
	// 检测连接
	if ($conn->connect_error) {
	    die("连接失败: " . $conn->connect_error);
	} 
	echo "连接成功";
	//解决Notice undefined index问题
	if(!empty($_POST['cardId'])) $cardId=$_POST['cardId'];else $cardId="";
	if(!empty($_POST['upassword'])) $upassword=$_POST['upassword'];else $upassword="";
	if(!empty($_POST['limits'])) $select=$_POST['limits'];else $select="";
	
	echo $cardId;
	echo $upassword;
	echo $select;
	
	
	if($select == 'manager'){
		$sql = "SELECT manID, mpassword FROM manager where manID ='$cardId'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
	    	// 输出数据
	    	while($row = mysqli_fetch_assoc($result)) {
	    	    if($row['manID'] == $cardId && $row['mpassword'] == $upassword){
		    		echo"<script type='text/javascript'>location='AdministratorBulletin.php';</script>";
		        	$_SESSION['cardId']=$cardId;
		        	echo $_SESSION['cardId'];
		    	}
		    	else{
		    		echo '<div style="position:absolute; left:65%; top:58%;color:red;font-size: 75%;">账号或密码错误！<div>';
		    	}
		    }
		}
		elseif($cardId!=null && $cardId!=""){
		    echo '<div style="position:absolute; left:65%; top:58%;color:red;font-size: 75%;">账号或密码错误！<div>';
		}
	}
	elseif($select == 'user'){
		$sql = "SELECT bankaccount, upassword FROM account where bankaccount ='$cardId'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
	    	// 输出数据
	    	while($row = mysqli_fetch_assoc($result)) {
	    	    if($row['bankaccount'] == $cardId && $row['upassword'] == $upassword){
		    		echo"<script type='text/javascript'>location='CapitalOperation.php';</script>";
		        	$_SESSION['cardId']=$cardId;
		    	}
		    	else{
		    		echo '<div style="position:absolute; left:65%; top:58%;color:red;font-size: 75%;">账号或密码错误！<div>';
		    	}
		    }
		}
		elseif($cardId!=null && $cardId!=""){
		    echo '<div style="position:absolute; left:65%; top:58%;color:red;font-size: 75%;">账号或密码错误！<div>';
		}
	}
?>