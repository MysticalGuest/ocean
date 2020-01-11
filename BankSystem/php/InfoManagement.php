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
	
	$queryNMAE = mysqli_query($conn, "select uname, sex from users where bankaccount='$cardId'");
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
			div.a1:hover{background-color: #eaf2ff}
			div.a2:hover{background-color: #eaf2ff}
			div.a3:hover{background-color: #eaf2ff}
			div.a4:hover{background-color: #eaf2ff}
			div.a6:hover{background-color: #eaf2ff}
			div.a7:hover{background-color: #eaf2ff}
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
				<div class="a3" style="position:absolute; left:12.5%; top:25%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="PersonalInformation.php"><font size="5%" face="STHeiTI">个人信息</font></a>
				</div>
				<div class="a4" style="position:absolute; left:12.5%; top:35%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);background-color: #ffe48d;text-align:center;">
					<a style=" text-decoration: none;" href="InfoManagement.php"><font size="5%" face="STHeiTI">信息管理</font></a>
				</div>
    	</div>
    	<div data-options="region:'center',border:false,title:'信息管理'" >
    	
			<div class="easyui-layout" data-options="fit:true" style="margin: 5px;padding: 5px;">
				<div data-options="region:'west',collapsible:false" style="width:50%;padding:10px" title="信息修改">
					<h2 style="padding-left: 35%;"><?php echo $rowNAME['uname']?>的基本信息</h2>
					<div style="padding-left: 20%;">
						<div class="easyui-panel" data-options="border:false" style="width:300px;padding:10px;">
							<form id="ModifyForm" onsubmit="return validateInformationForm();" action="InfoManagement.php" method="post">
								<table>
									<tr style="height: 40px;">
										<td>姓名:</td>
										<td><?php echo $rowNAME['uname']?></td>
									</tr>
									<tr style="height: 40px;">
										<td>身份证号:</td>
										<td><?php echo $cardId?></td>
									</tr>
									<tr style="height: 40px;">
										<td>性别:</td>
										<td><?php echo $rowNAME['sex']?></td>
									</tr>
									<tr style="height: 40px;">
										<td>手机号码:</td>
										<td><input name="tel" class="f1 easyui-textbox"></input></td>
									</tr>
									<tr style="height: 40px;"> 
										<td>年龄:</td>
										<td><input name="age" class="f1 easyui-numberbox"></input></td>
									</tr>
									<tr style="height: 40px;"> 
										<td>家庭地址:</td>
										<td><input name="address" class="f1 easyui-textbox"></input></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-left: 8%;padding-top: 20px;">
											<input style="width: 100px;height: 35px;font-size: 15px;
												border-radius: 5px;border:1px solid rgba(0,0,0,0);cursor:pointer;" type="submit" value="保存">	
											</input>
										</td>
									</tr>
								</table>
								<script>
									function validateInformationForm(){
										phone=document.forms["ModifyForm"]["tel"].value;
										age=document.forms["ModifyForm"]["age"].value;
										address=document.forms["ModifyForm"]["address"].value;
										if((phone==null || phone=="")&& (age==null||age=="")&&(address==null||address=="")){
											$.messager.alert('提示', '你没有填写任何信息！','info');
											return false;
										}
										else if(!(/^1[3-9]\d{9}$/.test(phone))&&!(phone==null || phone=="")){
										  	$.messager.alert('提示', '手机号码格式不规范！请重新填写！','info');
											return false;
										}
									}
								</script>
							</form>
						</div>
					</div>
				</div>
					
				<div data-options="region:'east',collapsible:false" style="width:50%;padding:10px" title="密码修改">
					<div style="padding-left: 12%;">
						<form id="passwordForm" onsubmit="return validatePasswordForm()" action="InfoManagement.php" method="post">
							<div class="easyui-panel" style="width:400px;padding:50px 60px;border-radius: 5px; padding-left: 12%;">
								<div style="margin-bottom:20px">
									<input name="oldPassword" class="easyui-passwordbox" 
										prompt="原密码" iconWidth="28" style="width:100%;height:34px;padding:10px"></input>
								</div>
								<div style="margin-bottom:20px">
									<input name="newPassword" class="easyui-passwordbox" 
										prompt="新密码" iconWidth="28" style="width:100%;height:34px;padding:10px"></input>
								</div>
								<div style="margin-bottom:20px">
									<input name="passwordAgain" class="easyui-passwordbox" 
										prompt="再输一次" iconWidth="28" style="width:100%;height:34px;padding:10px"></input>
								</div>
								<div  style="padding-left: 90px;">
									<input style="width: 100px;height: 35px;font-size: 15px;
										border-radius: 5px;border:1px solid rgba(0,0,0,0);cursor:pointer;" type="submit" value="保存">	
									</input>
								</div>
							</div>
							
							<script>
								function validatePasswordForm(){
									oldPassword=document.forms["passwordForm"]["oldPassword"].value;
									newPassword=document.forms["passwordForm"]["newPassword"].value;
									passwordAgain=document.forms["passwordForm"]["passwordAgain"].value;
									if (oldPassword==null || oldPassword==""){
									  	$.messager.alert('提示', '请填写原密码','info');
									  	return false;
									}
									else if(newPassword==null || newPassword==""){
										$.messager.alert('提示', '请填写新密码','info');
										return false;
									}
									else if(passwordAgain==null || passwordAgain==""){
										$.messager.alert('提示', '请再次填写密码','info');
										return false;
									}
									else if(newPassword!=passwordAgain){
										$.messager.alert('提示', '两次新密码不一致','info');
										return false;
									}
								}
							</script>
						</form>
					</div>
				</div>
				
				
			</div>
			
    	</div>
	</body>
</html>

<?php
	$tel=$_POST['tel'];
	$age=$_POST['age'];
	$address=$_POST['address'];
	
	$sql = "SELECT * FROM users where bankaccount ='$cardId'";
	$result = mysqli_query($conn, $sql);
	
	//修改电话号码
	if($tel!=null && $tel!=""){
		
		if (mysqli_num_rows($result) > 0) {
	    	// 输出数据
	    	$sqlUPDATEtel = "UPDATE users SET tel='$tel' WHERE bankaccount='$cardId'";
	    	mysqli_query($conn, $sqlUPDATEtel);
	    	echo"<script type='text/javascript'>$.messager.alert('', '修改成功!','info');</script>";
		    
		}
		else{
		    echo"
					<script type='text/javascript'>$.messager.alert('', '修改失败!'+'<br/>'+'请重新修改！','info',
							function(){
								location.href='LoginInterface.php'
							});
					</script>
				";
		}
		
	}
	
	//修改年龄
	if($age!=null && $age!=""){
		if (mysqli_num_rows($result) > 0) {
	    	// 输出数据
	    	$sqlUPDATEage = "UPDATE users SET age='$age' WHERE bankaccount='$cardId'";
	    	mysqli_query($conn, $sqlUPDATEage);
	    	while($row = mysqli_fetch_assoc($result)) {
	    	    echo"<script type='text/javascript'>$.messager.alert('', '修改成功!','info');</script>";
		    }
		}
		else{
		    echo"
					<script type='text/javascript'>$.messager.alert('', '修改失败!'+'<br/>'+'请重新修改！','info',
							function(){
								location.href='LoginInterface.php'
							});
					</script>
				";
		}
	}
	
	//修改家庭地址
	if($address!=null && $address!=""){
		if (mysqli_num_rows($result) > 0) {
	    	// 输出数据
	    	$sqlUPDATEaddress = "UPDATE users SET address='$address' WHERE bankaccount='$cardId'";
	    	mysqli_query($conn, $sqlUPDATEaddress);
	    	while($row = mysqli_fetch_assoc($result)) {
	    	    echo"<script type='text/javascript'>$.messager.alert('', '修改成功!','info');</script>";
		    }
		}
		else{
		    echo"
					<script type='text/javascript'>$.messager.alert('', '修改失败!'+'<br/>'+'请重新修改！','info',
							function(){
								location.href='LoginInterface.php'
							});
					</script>
				";
		}
	}

?>

<?php
	$oldPassword=$_POST['oldPassword'];
	$newPassword=$_POST['newPassword'];
	$passwordAgain=$_POST['passwordAgain'];
	
	$sqlPass = "SELECT * FROM account where bankaccount ='$cardId'";
	$resultPass = mysqli_query($conn, $sqlPass);
	
	if(mysqli_num_rows($resultPass) > 0){
		while($row = mysqli_fetch_assoc($resultPass)){
			if($row['upassword'] == $oldPassword){
				$sqlUPDATEpass = "UPDATE account SET upassword='$newPassword' where bankaccount='$cardId'";
				mysqli_query($conn, $sqlUPDATEpass);
				echo"
						<script type='text/javascript'>$.messager.alert('', '密码重置成功!'+'<br/>'+'请重新登录！','info',
								function(){
									location.href='LoginInterface.php'
								});
						</script>
					";
			}
			elseif($row['upassword'] != $oldPassword&&($oldPassword!=null||$oldPassword!="")){
				echo"<script type='text/javascript'>$.messager.alert('', '原密码错误!'+'<br/>'+'请重新试！','info')</script>";
			}
		}
	}
	else{
    	echo '<div style="position:absolute; left:65%; top:50%;color:red;font-size: 75%;">系统错误错误！请重试！<div>';
    }
?>