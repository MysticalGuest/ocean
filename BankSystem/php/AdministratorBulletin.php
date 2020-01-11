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
	
	$queryNMAE = mysqli_query($conn, "select managername from manager where manID='$cardId'");
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
			div.a2:hover{background-color: #eaf2ff}
			div.a3:hover{background-color: #eaf2ff}
			div.a4:hover{background-color: #eaf2ff}
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
					您好！<?php echo $rowNAME['managername']?>管理员！欢迎登录！
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
    			<div class="a1" style="position:absolute; left:12.5%; top:5%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);background-color: #ffe48d;text-align:center;">
					<a style=" text-decoration: none;" href="AdministratorBulletin.php"><font size="5%" face="STHeiTI">公告编辑</font></a>
				</div>
				<div class="a2" style="position:absolute; left:12.5%; top:15%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="UserManager.php"><font size="5%" face="STHeiTI">用户管理</font></a>
				</div>
				<div class="a3" style="position:absolute; left:12.5%; top:25%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="RichestList.php"><font size="5%" face="STHeiTI">富豪排行</font></a>
				</div>
				<div class="a4" style="position:absolute; left:12.5%; top:35%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="ChangePassword.php"><font size="5%" face="STHeiTI">修改密码</font></a>
				</div>
    	</div>
    	<div data-options="region:'center',border:false" style="background:#fff;" >
    		<div id="cc" class="easyui-layout" data-options="fit:true">
    			
  				<div id="cd" class="easyui-layout"  style="width: 80%;height: 80%;left:10%;top:5%">
    				<div data-options="region:'east',title:'编辑公告',collapsible:false" style="width:65%;height:100%;padding: 10px;">
    					<input name="context" id="context" class="f1 easyui-textbox" data-options="multiline:true,prompt:'请编辑新的公告！'"style="height: 60%;width: 100%;"></input>
    					
    					<button style="width: 100px;height: 35px;font-size: 15px;margin-top: 5%;margin-left: 65%;
    						border-radius: 5px;border:1px solid rgba(0,0,0,0);cursor:pointer;" onclick="return validate()">保存</button>
    				</div>
    				<script>
						function validate(){
							context=document.getElementById("context").value;
							if (context==null || context==""){
							  	$.messager.alert('提示', '公告不能为空！','info');
							  	return false;
						   }
						}
					</script>
   					<div data-options="region:'west',title:'历史公告',collapsible:false" style="width:35%;height:100%;padding: 10px;">
   						<?php
   							$notice = mysqli_query($conn, "select context from notice where manID='$cardId'");
   							if (mysqli_num_rows($notice) > 0) {
						    	// 输出数据
						    	while($row = mysqli_fetch_assoc($notice)) {
						    	    echo '【公告】：';
						    	    echo $row['context'];
						    	    echo '<br>';
							    }
							}
   						?>
   						<div style="font-size: 15px;text-decoration: none;display: block;font-family: YouYuan, helvetica, sans-serif;padding-bottom: 10px;">【公告】:欢迎使用银行系统！</div>
   						<div style="font-size: 15px;text-decoration: none;display: block;font-family: YouYuan, helvetica, sans-serif;padding-bottom: 10px;">【公告】:欢迎使用银行系统！</div>
   						<div style="font-size: 15px;text-decoration: none;display: block;font-family: YouYuan, helvetica, sans-serif;padding-bottom: 10px;">【公告】:欢迎使用银行系统！</div>
   					</div>
				</div>
  				
			</div>
    	</div>
	</body>
</html>

<?php
	$context=$_POST['context'];
	
	$sql="INSERT INTO notice values";
	
?>
