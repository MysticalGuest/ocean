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
			div.a1:hover{background-color: #eaf2ff}
			div.a2:hover{background-color: #eaf2ff}
			div.a3:hover{background-color: #eaf2ff}
			div.a4:hover{background-color: #eaf2ff}
			div.a5:hover{background-color: #eaf2ff}
		</style>
		<style type="text/css">
			/*密码强度显示控制*/
            body {
                font: 12px/1.5 Arial;
            }
            #tips {
                float: left;
                margin: 2px 0 0 0px;
            }
 
            #tips span {
                float: left;
                width: 45px;
                height: 20px;
                color: white;
                border-radius: 5px;
                background: #4CBDEE;
                margin-right: 2px;
                line-height: 20px;
                text-align: center;
            }
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
    			<div class="a1" style="position:absolute; left:12.5%; top:5%;padding:5%;width:75%;
    				border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="AdministratorBulletin.php"><font size="5%" face="STHeiTI">公告编辑</font></a>
				</div>
				<div class="a2" style="position:absolute; left:12.5%; top:15%;padding:5%;width:75%;
					border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="UserManager.php"><font size="5%" face="STHeiTI">用户管理</font></a>
				</div>
				<div class="a3" style="position:absolute; left:12.5%; top:25%;padding:5%;width:75%;
					border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="RichestList.php"><font size="5%" face="STHeiTI">富豪排行</font></a>
				</div>
				<div class="a4" style="position:absolute; left:12.5%; top:35%;padding:5%;width:75%;
					border-radius:10px; border:1px solid rgba(0,0,0,0);background-color: #ffe48d;text-align:center;">
					<a style=" text-decoration: none;" href="ChangePassword.php"><font size="5%" face="STHeiTI">修改密码</font></a>
				</div>
    	</div>
    	<div data-options="region:'center',border:false" style="background:#fff;" >
			<div class="easyui-panel" title="修改密码" style="width:100%;height:100%;padding:10px;">
				<form id="passwordForm" onsubmit="return validateForm();" action="ChangePassword.php" method="post">
					<div style="padding-left: 30%;padding-top: 6%;">
						<div  class="easyui-panel" style="width:400px;padding:50px 60px;border-radius: 5px;">
							<div style="margin-bottom:20px">
								<input name="oldPassword" class="easyui-passwordbox" prompt="原密码" iconWidth="28" style="width:100%;height:34px;padding:10px">
							</div>
							<div style="margin-bottom:20px" id="inputPassword">
								<input id="newPassword" name="newPassword" class="easyui-passwordbox" prompt="新密码" iconWidth="28" style="width:100%;height:34px;padding:10px">
								<font id="num" style="float: right;"></font>
							</div>
							<div style="margin-bottom:20px">
								<input name="passwordAgain" class="easyui-passwordbox" prompt="再输一次" iconWidth="28" style="width:100%;height:34px;padding:10px">
							</div>
							<div style="margin-bottom:20px">
								<font style="float: left;">强度：</font>
								<div id="tips" style="padding-left: 20px;"><span></span><span></span><span></span><span></span></div>
							</div>
							<div  style="padding-left: 90px;padding-top: 50px;">
								<input style="width: 100px;height: 35px;font-size: 15px;
									border-radius: 5px;border:1px solid rgba(0,0,0,0);cursor:pointer;" type="submit" value="保存"></input>
							</div>
						</div>
					</div>
					<script>
						function validateForm(){
							oldPassword=document.forms["passwordForm"]["oldPassword"].value;
							newPassword=$("#newPassword").val();
							//newPassword=document.forms["passwordForm"]["newPassword"].value;
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
							else if(newPassword.length<6||passwordAgain.length<6){
								$.messager.alert('提示', '密码至少大于等于6位!'+'<br>'+'请重新填写！','info');
							  	return false;
							}
							else if(newPassword!=passwordAgain){
								$.messager.alert('提示', '两次新密码不一致','info');
								return false;
							}
						}
					</script>
					<script type="text/javascript">
			            $(function() {
			                var aStr = ["弱", "中", "强", "牛逼"];
			 
			                function checkStrong(val) {
			                    var modes = 0;
			                    if (val.length < 6) return 0;
			                    if (/\d/.test(val)) modes++; //数字
			                    if (/[a-z]/.test(val)) modes++; //小写
			                    if (/[A-Z]/.test(val)) modes++; //大写  
			                    if (/\W/.test(val)) modes++; //特殊字符
			                    if (val.length > 12) return 4;
			                    return modes;
			                };
			                $('#inputPassword').keyup(function() {
			                    var val = document.getElementById("newPassword").value;
			                    $("#num").text(val.length);
			                    var num = checkStrong(val);
			                    switch (num) {
			                        case 0:
			                            break;
			                        case 1:
			                            $("#tips span").css('background', 'yellow').text('').eq(num - 1).css('background', '#FF8080').text(aStr[num - 1]);
			                            break;
			                        case 2:
			                            $("#tips span").css('background', '#4CBDEE').text('').eq(num - 1).css('background', '#FF8080').text(aStr[num - 1]);
			                            break;
			                        case 3:
			                            $("#tips span").css('background', '#4CBDEE').text('').eq(num - 1).css('background', '#FF8080').text(aStr[num - 1]);
			                            break;
			                        case 4:
			                            $("#tips span").css('background', '#4CBDEE').text('').eq(num - 1).css('background', '#FF8080').text(aStr[num - 1]);
			                            break;
			                        default:
			                            break;
			                    }
			                })
			            })
			        </script>
				</form>
						
			</div>
    	</div>
	</body>
</html>

<?php
	$oldPassword=$_POST['oldPassword'];
	$newPassword=$_POST['newPassword'];
	$passwordAgain=$_POST['passwordAgain'];
	
	$sqlPass = "SELECT * FROM manager where manID ='$cardId'";
	$resultPass = mysqli_query($conn, $sqlPass);
	
	if(mysqli_num_rows($resultPass) > 0){
		while($row = mysqli_fetch_assoc($resultPass)){
			if($row['mpassword'] == $oldPassword){
				$sqlUPDATEpass = "UPDATE manager SET mpassword='$newPassword' where manID='$cardId'";
				mysqli_query($conn, $sqlUPDATEpass);
				echo"
						<script type='text/javascript'>$.messager.alert('', '密码重置成功!'+'<br/>'+'请重新登录！','info',
								function(){
									location.href='LoginInterface.php'
								});
						</script>
					";
			}
			elseif($row['mpassword'] != $oldPassword&&($oldPassword!=null||$oldPassword!="")){
				echo"<script type='text/javascript'>$.messager.alert('', '原密码错误!'+'<br/>'+'请重新试！','info')</script>";
			}
		}	
	}
	else{
    	echo '<div style="position:absolute; left:65%; top:50%;color:red;font-size: 75%;">系统错误错误！请重试！<div>';
    }

?>