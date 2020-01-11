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
	
	$bankaccount = $_GET['bankaccount'];
	$state = $_GET['state'];
	echo $bankaccount;
	echo $state;
	if($state==0){
		$sql = "UPDATE account SET state=1 where bankaccount='$bankaccount'";
		$result = mysqli_query($conn, $sql);
		if($result){
			echo"
					<script type='text/javascript'>$.messager.alert('提示', '用户解禁成功!','info',
							function(){
								location.href='UserManager.php'
							});
					</script>
				";
		}
		else{
			echo"
					<script type='text/javascript'>$.messager.alert('提示', '用户解禁失败!'+'<br/>'+'请重试！','info',
							function(){
								location.href='UserManager.php'
							});
					</script>
				";
		}
	}
	elseif($state==1){
		echo"
				<script type='text/javascript'>$.messager.alert('提示', '失败！'+'<br/>'+'用户当前处于解禁状态!','info',
						function(){
							location.href='UserManager.php'
						});
				</script>
			";
	}
		

?>