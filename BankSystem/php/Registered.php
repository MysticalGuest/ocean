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
		<div style="position:absolute; left:66%; top:16%;">
			<font size="5%" face="STHeiTI" color="grey">账号注册</font>
		</div>
        <div style="position:absolute; left:60%; top:21%;">
        	<form action="register" method="post" id="registerForm">
				<table>
					<tr style="height: 35px;">
						<td>姓名:</td>
						<td><input id="name" name="name"   class="easyui-textbox" data-options="required:true"></input></td>
					</tr>
					<tr style="height: 35px;">
						<td>身份证号:</td>
						<td><input id="Idcard" name="IDcard" class="f1 easyui-textbox" data-options="required:true"></input></td>
					</tr>
					<tr style="height: 35px;">
						<td>性别:</td>
						<td>
							<form id="ww">
								<div style="float: left;">
									<input class="easyui-radiobutton" id="man" name="sex" value="man" label="男:" labelWidth="30" checked="checked">
								</div>
								<div style="margin-left: 20px;float: left;">
									<input class="easyui-radiobutton" id="woman" name="sex" value="woman" label="女:" labelWidth="30">
								</div>
							</form>
						</td>
					</tr>
					<tr style="height: 35px;">
						<td>手机号码:</td>
						<td><input id="tel" name="tel" class="f1 easyui-textbox"></input></td>
					</tr>
					<tr style="height: 35px;"> 
						<td>年龄:</td>
						<td><input id="age" name="age" class="f1 easyui-numberbox"></input></td>
					</tr>
					<tr style="height: 35px;"> 
						<td>家庭地址:</td>
						<td><input id="address" name="address" class="f1 easyui-textbox"></input></td>
					</tr>
					<tr style="height: 35px;"> 
						<td>密保问题:</td>
						<td>
							<select id="select" name="question" class="easyui-combobox" name="state" style="width:174px;">
								<option value="question" selected>选择问题</option>
								<option value="父亲的名字">父亲的名字</option>
								<option value="母亲的名字">母亲的名字</option>
							</select>
						</td>
					</tr>
					<tr style="height: 35px;">
						<td>密保答案:</td>
						<td><input id="answer" name="answer" class="easyui-textbox" data-options="required:true"></input></td>
					</tr>
					<tr style="height: 35px;"> 
						<td>密码:</td>
						<td>
							<div id="inputPassword">
							<input name="password" id="password" class="f1 easyui-passwordbox" data-options="required:true"></input>
							</div>
						</td>
						<td><font id="num" style="float: right;"></font></td>
					</tr>
					<tr style="height: 35px;"> 
						<td>强度:</td>
						<td><div id="tips"><span></span><span></span><span></span><span></span></div></td>
					</tr>
					<tr>
						<td></td>
						<td style="padding-left: 10%;">
							<button style="width: 100px;height: 35px;font-size: 15px;
								border-radius:3px; border:1px grey; background-color: grey; color:white;cursor:pointer;"
										onclick="return validateForm()">保存</button>
						</td>
					</tr>
				</table>
			</form>
			<script>
				function validateForm(){
					var userId = 1212121;
        			var cardId = 1212121;
        			name=document.getElementById("name").value;
        			answer=document.getElementById("answer").value;
        			pass=$("#password").val();
					cardIdOfInput=document.getElementById("Idcard").value;
					phone=$("#tel").val();
					if(name==null || name==""){
						$.messager.alert('提示', '请填写姓名！','info');
						return false;
					}
					if(cardIdOfInput==null || cardIdOfInput==""){
						$.messager.alert('提示', '请填写身份证号码！','info');
						return false;
					}
					else if(!(/^[1-9][0-7]\d{4}((19\d{2}(0[13-9]|1[012])(0[1-9]|[12]\d|30))|(19\d{2}(0[13578]|1[02])31)|(19\d{2}02(0[1-9]|1\d|2[0-8]))|(19([13579][26]|[2468][048]|0[48])0229))\d{3}(\d|X|x)?$/.test(cardIdOfInput))){
					 	$.messager.alert('提示', '身份证号格式不规范！请重新填写！','info');
					  	return false;
					}
					if(!(/^1[3-9]\d{9}$/.test(phone))&&!(phone==null || phone=="")){ 
						$.messager.alert('提示', '手机号码格式不规范！请重新填写！','info');
						return false; 
					}
					if(answer==null || answer==""){
						$.messager.alert('提示', '请回答密保问题！','info');
						return false;
					}
					if(pass==null || pass==""){
						$.messager.alert('提示', '请填写登录密码！','info');
						return false;
					}
					else if(pass.length>20||pass.length<6){
						$.messager.alert('提示', '密码长度必须大于6位或小于20位！','info');
						return false;
					}
					else{
						$.messager.alert('提示', '注册成功!'+'<br/>'+'你的用户账号是'+userId+'<br/>'+'你的银行卡号是'+cardId,'info',
							function(){
								location.href="LoginInterface.php"
							}
						);
						return true;
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
	                    var val = document.getElementById("password").value;
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
        </div>
	</body>
</html>

<?php

?>