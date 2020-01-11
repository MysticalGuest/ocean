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
	
	$queryNMAE = mysqli_query($conn, "select uname from users where bankaccount='$cardId'");
	$rowNAME = mysqli_fetch_assoc($queryNMAE);
	$queryMONEY = mysqli_query($conn, "select banlance from account where bankaccount='$cardId'");
	$rowMONEY = mysqli_fetch_assoc($queryMONEY);
	
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

    	<div data-options="region:'west',border:true,split:false,collapsible:false" 
    		style="width:200px; background-color: #f8f8f8; border:2px solid grey;">
    			<div class="a1" style="position:absolute; left:12.5%; top:5%;padding:5%;width:75%;
    				border-radius:10px; border:1px solid rgba(0,0,0,0);background-color: #ffe48d;text-align:center;">
					<a style=" text-decoration: none;" href="CapitalOperation.php"><font size="5%" face="STHeiTI">资金操作</font></a>
				</div>
    			<div class="a2" style="position:absolute; left:12.5%; top:15%;padding:5%;width:75%;
    				border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="TransactionRecord.php"><font size="5%" face="STHeiTI">交易记录</font></a>
				</div>
				<div class="a3" style="position:absolute; left:12.5%; top:25%;padding:5%;width:75%;
					border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="PersonalInformation.php"><font size="5%" face="STHeiTI">个人信息</font></a>
				</div>
				<div class="a4" style="position:absolute; left:12.5%; top:35%;padding:5%;width:75%;
					border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="InfoManagement.php"><font size="5%" face="STHeiTI">信息管理</font></a>
				</div>
    		
    	</div>
    	<div data-options="region:'center',border:false" style="background:#fff;" >
    		<div class="easyui-layout" data-options="fit:true">
				<div style="padding-left:60%; padding-top:2%;">
					<img src="../img/title.png" width="400">
				</div>
				<div class="easyui-tabs" data-options="tabWidth:150" style="width:100%;height:80%;padding: 10px;">
					<div title="转账" style="padding:20px">
						<div class="easyui-panel" data-options="border:false" 
							style="width:100%;margin-left: 10%;float:left">	
							<table>
								<tr style="height: 60px;">
									<td>账户余额:</td>
									<td><?php echo $rowMONEY['banlance']?>元</td>
								</tr>
								<tr style="height: 60px;">
									<td>收款用户:</td>
									<td><input id="collection" name="collection" class="f1 easyui-textbox" data-options="required:true"></input></td>
								</tr>
								<tr style="height: 60px;">
									<td>转账金额:</td>
									<td><input id="money" name="money" class="f1 easyui-numberbox" style="width: 160px;"></input>元</td>
								</tr>
								<tr style="height: 60px;">
									<td>输入密码:</td>
									<td><input id="upassword" name="upassword" class="f1 easyui-passwordbox"></input></td>
								</tr>
								<tr>
									<td></td>
									<td style="padding-left: 7%;">
										<button style="width: 100px;height: 35px;font-size: 15px;
											border-radius: 5px;border:1px solid rgba(0,0,0,0);cursor:pointer;" 
											onclick="return validateForm()">确定</button></td>
								</tr>
							</table>
						</div>
							
						<script>
							function validateForm(){
								x=10000;
								collection=document.getElementById("collection").value;
								money=document.getElementById("money").value;
								upassword=document.getElementById("upassword").value;
								if(collection==null || collection==""){
									$.messager.alert('提示', '请填写用户账号','info');
									return false;
								}
								else if(!( /([\d]{4})([\d]{4})([\d]{4})([\d]{4})([\d]{0,})?/.test(collection))){
								 	$.messager.alert('提示', '账号格式不规范！请重新填写！','info');
								  	return false;
								}
								else if(money==null || money==""){
									$.messager.alert('提示', '请填写转账金额！','info');
									return false;
								}
								else if(money<0){
									$.messager.alert('提示','金额不能为负！','info');
								}
								else if(upassword==null || upassword==""){
									$.messager.alert('提示', '请填写密码！','info');
									return false;
								}
								else if (x<money){
								  	$.messager.alert('提示', '账户余额不足！','info');
								  	return false;
								}
								
							}
						</script>
					</div>
				</div>
			</div>
    	</div>
	</body>
</html>

<?php
	$splTRANSFER="";
?>