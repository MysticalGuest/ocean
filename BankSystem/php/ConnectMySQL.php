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
	$conn = new mysqli($servername,$username,$password,$database);
	mysqli_query($conn,"set names utf8"); 
 
	// 检测连接
	if ($conn->connect_error) {
	    die("连接失败: " . $conn->connect_error);
	} 
	echo "连接成功";
	
	$sql = "SELECT * FROM dealdetail"; 
	$result = mysqli_query($conn,$sql); 
	  
	$arr = array(); 
	while($row = mysqli_fetch_array($result)) { 
	  $count=count($row);//不能在循环语句中，由于每次删除 row数组长度都减小 
	  for($i=0;$i<$count;$i++){ 
	    unset($row[$i]);//删除冗余数据 
	  } 
	  
	  array_push($arr,$row); 
	  
	} 
	$data=json_encode($arr,JSON_UNESCAPED_UNICODE);
	echo $data;
?>