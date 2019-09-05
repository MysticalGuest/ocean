<?php session_start(); ?>
	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>银行系统服务平台</title>
		<link rel="shortcut icon" href="../img/fbadge.ico"  type="image/x-icon"/>
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
			<font size="5%" face="STHeiTI" color="grey">密码找回</font>
		</div>
		<div id="demo" style="position:absolute; left:65%; top:59%;color:red;font-size: 75%;"></div>
		<div style="position:absolute; left:60%; top:35%;">
        	<form id="encryptedForm" onsubmit="return validateForm();" action="RtrievePassword.php" method="post">
				<table>
					<tr style="height: 40px;">
						<td>账号:</td>
						<td><input name="cardId" class="easyui-textbox" data-options="required:true"></input></td>
					</tr>
					
					<tr style="height: 40px;"> 
						<td>密码问题:</td>
						<td>
							<select id="select" name="select" class="easyui-combobox" name="state" style="width:174px;">
								<option value="question" selected>选择问题</option>
								<option value="你父亲叫什么？">你父亲叫什么？</option>
								<option value="你母亲叫什么？">你母亲叫什么？</option>
							</select>
						</div>
						</td>
					</tr>
					<tr style="height: 40px;">
						<td>密保答案:</td>
						<td><input name="answer" class="easyui-textbox" data-options="required:true"></input></td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 13%;padding-top: 10%;">
							<input style="width: 100px;height: 35px;font-size: 15px;
								border-radius:3px; border:1px grey; background-color: grey; color:white;cursor:pointer;" type="submit" value="提交">	
							</input>
						</td>
					</tr>
				</table>
				<script>
					function validateForm() {
						var cardId=document.forms["encryptedForm"]["cardId"].value;
						var answer=document.forms["encryptedForm"]["answer"].value;
						var question=document.forms["encryptedForm"]["select"].value;
						if(cardId==null || cardId==""){
							$.messager.alert('提示', '请填写账号！', "info");
							return false;
						}
						else if(question=="question"){
							$.messager.alert('提示', '请选择问题！', "info");
							return false;
						}
						else if(answer=="" || answer==null){
							$.messager.alert('提示', '请回答密保问题！',"info");
							return false;
						}
					}
				</script>
			</form>
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
	if(!empty($_POST['select'])) $question=$_POST['select'];else $question="";
	if(!empty($_POST['answer'])) $answer=$_POST['answer'];else $answer="";
	
//	$cardId=$_POST['cardId'];
//	$question=$_POST['select'];
//	$answer=$_POST['answer'];
	echo $cardId;
	echo $question;
	echo $answer;
	
	$sql = "SELECT bankaccount, question, answers FROM users where bankaccount ='$cardId'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
    	// 输出数据
    	while($row = mysqli_fetch_assoc($result)) {
    	    if($row['bankaccount'] == $cardId && $row['question'] == $question && $row['answers'] == $answer){
				echo"
						<script type='text/javascript'>$.messager.alert('提示', '密码找回成功!'+'<br/>'+'请重置密码！','info',
								function(){
									location.href='passwordReset.php'
								});
						</script>
					";
	    		$_SESSION['cardId']=$cardId;
	    	}
	    	else{
	    		echo $row['question'];
	    		echo '<div style="position:absolute; left:65%; top:55%;color:red;font-size: 75%;">密保问题或密保答案错误！<div>';
	    	}
	    }
	}
	elseif($cardId!=null && $cardId!=""){
	    echo '<div style="position:absolute; left:65%; top:55%;color:red;font-size: 75%;">账号不存在！<div>';
	}
?>