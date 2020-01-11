<?php session_start();?>

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
		<script type="text/javascript" src="../easyui/locale/easyui-lang-zh_CN.js"></script>
	</head>
	<body></body>
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
	//echo "连接成功";
	
	$bankaccount=$_GET['bankaccount'];
	
	$passwordAgain=$_GET['passwordAgain'];
//	echo '<div style="position:absolute; left:65%; top:55%;color:red;font-size: 75%;"><div>'.$bankaccount;
//	echo '<div style="position:absolute; left:65%; top:60%;color:red;font-size: 75%;"><div>'.$passwordAgain;
	$sqlPASS="SELECT * FROM account WHERE bankaccount ='$bankaccount'";
	$resultPASS=mysqli_query($conn, $sqlPASS);
//	echo '<div style="position:absolute; left:65%; top:60%;color:red;font-size: 75%;"><div>'.mysqli_num_rows($resultPASS);
	if((mysqli_num_rows($resultPASS) > 0)&&!($passwordAgain==null||$passwordAgain=="")){
		mysqli_query($conn, "UPDATE account SET upassword='$passwordAgain' where bankaccount ='$bankaccount'");
		echo"<script type='text/javascript'>$.messager.alert('', '修改成功!','info',
				function(){
					location.href='UserManager.php'
				});</script>
			";
	}
	elseif((mysqli_num_rows($resultPASS) == 0)&&!($passwordAgain==null||$passwordAgain=="")){
		echo"<script type='text/javascript'>$.messager.alert('', '修改失败!','info',
				function(){
					location.href='UserManager.php'
				});</script>
			";
	}
?>