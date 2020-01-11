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
	$cardId=$_SESSION['cardId'];
	
	$queryNMAE = mysqli_query($conn, "select * from users where bankaccount='$cardId'");
	$rowNAME = mysqli_fetch_assoc($queryNMAE);

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
		<script type="text/javascript" src="../easyui/locale/easyui-lang-zh_CN.js"></script>
		<style type="text/css">
			a:link {color: black}
			a:visited {color: black}
			a:hover {color:grey}
			a:active {color: black}
			div.a1:hover{background-color: #eaf2ff}
			div.a2:hover{background-color: #eaf2ff}
			div.a3:hover{background-color: #eaf2ff}
			div.a5:hover{background-color: #eaf2ff}
			div.a6:hover{background-color: #eaf2ff}
		</style>
	</head>
	<body class="easyui-layout">
   		<div data-options="region:'north',border:false,split:false,collapsible:false" style="height:110px;">
   			<div class="North">
   				<div class="heading_img1">
					<img src="../img/badgewhite.png">
				</div>
   				<div class="font1">
					银行系统
				</div>
				<div class="font2">
					您好！<?php echo $rowNAME['uname']?>！欢迎登录！
					<div class="heading_img2">
						<img src="../img/exit.png" style="position: absolute;right:5%;top:50%;">
						<div style="position: absolute;right:2%;top:60%;">
							<style type="text/css">
								a.a:link {color: white}
								a.a:visited {color: white}
								a.a:hover {color:grey}
								a.a:active {color: white}
							</style>
							<a class="a" href="LoginInterface.php" style=" text-decoration: none;">退出</a> 
						</div>
					</div>
				</div>
   			</div>
   		</div>

    	<div data-options="region:'west',border:true,split:false,collapsible:false" style="width:200px; background-color: #f8f8f8; border:2px solid grey;">
    			<div class="a1" style="position:absolute; left:12.5%; top:5%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="CapitalOperation.php"><font size="5%" face="STHeiTI">资金操作</font></a>
				</div>
    			<div class="a2" style="position:absolute; left:12.5%; top:15%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="TransactionRecord.php"><font size="5%" face="STHeiTI">交易记录</font></a>
				</div>
				<div class="a3" style="position:absolute; left:12.5%; top:25%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);background-color: #ffe48d;text-align:center;">
					<a style=" text-decoration: none;" href="PersonalInformation.php"><font size="5%" face="STHeiTI">个人信息</font></a>
				</div>
				<div class="a4" style="position:absolute; left:12.5%; top:35%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="InfoManagement.php"><font size="5%" face="STHeiTI">信息管理</font></a>
				</div>
    		
    	</div>
    	<div data-options="region:'center',border:false,title:'个人信息'" style="" >
    		<div style="margin:9px 0;">
    			<div>
    				<img src="../img/default.png" style="margin-left:40px;height: 120px;">
    			</div>
    		</div>
			<div class="easyui-tabs" data-options="tabWidth:150" style="width:100%;height:70%;padding: 5px;">
				<div title="基本信息" style="padding:20px;">
					<div style="width: 50%;float: left;">
						<label for="i2">
							<div style="padding: 10px;">
								<div style="font-weight:700;display: inline;">账号：</div>
								<div style="display: inline;"><?php echo $rowNAME['bankaccount']?></div>
							</div>
						</label>
						<label for="i2">
							<div style="padding: 10px;">
								<div style="font-weight:700;display: inline;">证件类型：</div>
								<div style="display: inline;">身份证</div>
							</div>
						</label>
						<label for="i2">
							<div style="padding: 10px;">
								<div style="font-weight:700;display: inline;">年龄：</div>
								<div style="display: inline;"><?php echo $rowNAME['age']?></div>
							</div>
						</label>
					</div>
					<div style="width: 50%;float: right;">
						<label for="i2">
							<div style="padding: 10px;">
								<div style="font-weight:700;display: inline;">姓名：</div>
							<div style="display: inline;"><?php echo $rowNAME['uname']?></div>
							</div>
						</label>
						<label for="i2">
							<div style="padding: 10px;">
								<div style="font-weight:700;display: inline;">证件号码：</div>
							<div style="display: inline;"><?php echo $rowNAME['ID']?></div>
							</div>
						</label>
						<label for="i2">
							<div style="padding: 10px;">
								<div style="font-weight:700;display: inline;">性别：</div>
								<div style="display: inline;"><?php echo $rowNAME['sex']?></div>
							</div>
						</label>
					</div>	
				</div>
				<div title="联系方式" style="padding:20px">
					<div style="width: 50%;float: left;">
						<label for="i2">
							<div style="padding: 10px;">
								<div style="font-weight:700;display: inline;">手机号：</div>
								<div style="display: inline;"><?php echo $rowNAME['tel']?></div>
							</div>
						</label>
						
					</div>
					<div style="width: 50%;float: right;">
						<label for="i2">
							<div style="padding: 10px;">
								<div style="font-weight:700;display: inline;">家庭地址：</div>
								<div style="display: inline;"><?php echo $rowNAME['address']?></div>
							</div>
						</label>
						
					</div>
				</div>
			
			</div>
    	</div>
	</body>
</html>