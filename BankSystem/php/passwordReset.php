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
			<font size="5%" face="STHeiTI" color="grey">重置密码</font>
		</div>
		<div id="demo" style="position:absolute; left:65%; top:59%;color:red;font-size: 75%;"></div>
		<div style="position:absolute; left:60%; top:35%;">
        	<form id="ff" onsubmit="return validateForm();" action="passwordReset.php" method="post" >
				<table>
					<tr style="height: 40px;">
						<td>新密码:</td>
						<td>
							<div id="inputPassword">
							<input name="newPassword" id="newPassword" class="f1 easyui-passwordbox" data-options="required:true"></input>
							</div>
						</td>
						<td><font id="num" style="float: right;"></font></td>
					</tr>
					<tr style="height: 40px;">
						<td>再输一次:</td>
						<td><input name="passwordAgain" class="easyui-passwordbox" data-options="required:true"></input></td>
					</tr>
					<tr style="height: 40px;"> 
						<td>强度:</td>
						<td><div id="tips"><span></span><span></span><span></span><span></span></div></td>
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
					function validateForm(){
						x=$("#newPassword").val();
						y=document.forms["ff"]["passwordAgain"].value;
						if (x==null || x==""){
						  	$.messager.alert('提示', '请填写新密码');
						  	return false;
					 	}
						else if(y==null || y==""){
							$.messager.alert('提示', '请再次填写密码');
							return false;
						}
						else if(x!=y){
							$.messager.alert('提示', '两次新密码不一致');
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
	if(!empty($_POST['newPassword'])) $newPassword=$_POST['newPassword'];else $newPassword="";
	if(!empty($_POST['passwordAgain'])) $passwordAgain=$_POST['passwordAgain'];else $passwordAgain="";
	
	$cardId=$_SESSION['cardId'];
	echo $cardId;
	
	$sql = "SELECT * FROM account where bankaccount ='$cardId'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
    	// 修改密码
    	if($newPassword!=null&&$newPassword!=""&&$passwordAgain!=null&&$passwordAgain!=""){
    		$sqlUPDATE = "UPDATE account SET upassword='$newPassword' where bankaccount ='$cardId'";
	    	mysqli_query($conn, $sqlUPDATE);
	    	while($row = mysqli_fetch_assoc($result)) {
	    		echo"
						<script type='text/javascript'>$.messager.alert('提示', '密码重置成功!'+'<br/>'+'请重新登录！','info',
								function(){
									location.href='LoginInterface.php'
								});
						</script>
					";
	    	}
    	}	
    }
    
    elseif($newPassword!=null&&$newPassword!=""&&$passwordAgain!=null&&$passwordAgain!=""){
    	echo"
				<script type='text/javascript'>$.messager.alert('提示', '密码重置失败!'+'<br/>'+'请继续找回密码！','info',
						function(){
							location.href='LoginInterface.php'
						});
				</script>
			";
    }

?>