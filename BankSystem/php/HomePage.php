<?php 
	session_start();
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
	//echo "连接成功";
	//全局变量，保存从登录界面传来的cardId

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html" charset="utf-8">
		<title>银行系统服务平台</title>
		<link rel="shortcut icon" href="../img/fbadge.ico"  type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" type="text/css" href="../easyui/themes/default/easyui.css">
		<link rel="stylesheet" type="text/css" href="../easyui/themes/icon.css">
		<link rel="stylesheet" type="text/css" href="../easyui/demo/demo.css">
		<script type="text/javascript" src="../easyui/jquery.min.js"></script>
		<script type="text/javascript" src="../easyui/jquery.easyui.min.js"></script>
		<style type="text/css">
			a:link {color: black}
			a:visited {color: black}
			a:hover {color:white}
			a:active {color: black}
			div.a1:hover{background-color: #0B85C6}
			div.a2:hover{background-color: #0B85C6}
			div.a3:hover{background-color: #eaf2ff}
		</style>
	</head>
	<body class="easyui-layout">
		<div id="cc" class="easyui-layout" style="width:100%;height:100%;">
    		<div data-options="region:'north'" style="height:30%;width: 100%;">
    			<div data-options="region:'north'" style="height:37%;width: 100%;background-color: #0066B3;"></div>
    			<div data-options="region:'south',border:false,collapsible:false" style="height:63%;">
    				<div>
						<img src="../img/badge.png" style="margin-left: 10%;margin-right: 2%;margin-top: 2%;display: inline;width: 60px;height: 60px;float: left;">
					</div>
					<div style="font-family: YouYuan, helvetica, sans-serif;font-size: 40px;padding-top: 3%;">
						银行系统
					</div>
    				<div class="a1" style="position:absolute;left:74%; top:65%;width:9%;height:22%;border-radius:5%; border:1px solid rgba(0,0,0,0);text-align:center;">
						<a style=" text-decoration: none;" href="LoginInterface.php"><font size="6%" face="YouYuan, helvetica, sans-serif" >登录</font></a>
					</div>
					<div class="a2" style="position:absolute;left:84%; top:65%;width:9%;height:22%;border-radius:5%; border:1px solid rgba(0,0,0,0);text-align:center;">
						<a style=" text-decoration: none;" href="Registered.php"><font size="6%" face="YouYuan, helvetica, sans-serif" >注册</font></a>
					</div>
    			</div>
    			
    		</div>
    		<div data-options="region:'south',border:true,collapsible:false" style="height:22%;padding-left:10%;padding-right: 10%;">
    			<div style="height: 20%;background-color: #1C82FE;padding: 5px;">
    				公告
    			</div>
    			<div style="border: dashed;height: 80%;">
    				<?php
						$notice = mysqli_query($conn, "select context from notice");
						if (mysqli_num_rows($notice) > 0) {
					    	// 输出数据
					    	while($row = mysqli_fetch_assoc($notice)) {
					    	    echo '【公告】：';
					    	    echo $row['context'];
					    	    echo '<br>';
						    }
						}
					?>
    			</div>
    		</div>
    		
   	 		<div data-options="region:'center',border:false,collapsible:false">
   	 			<img src="../img/Theme.jpg" style="width:100%;height:99%;">
   	 		</div>
		</div>
	</body>
</html>

<?php

?>