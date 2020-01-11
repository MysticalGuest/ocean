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
	
	if(!empty($_GET['cardIdQuery'])) $cardIdQuery=$_GET['cardIdQuery'];else $cardIdQuery="";
	if($cardIdQuery==null||$cardIdQuery==""){
		$sqlSELECT = "SELECT ID,account.bankaccount,uname,state,adate,versions FROM account,users where account.bankaccount=users.bankaccount";
	}
	else{
		$sqlSELECT = 
		"	SELECT ID,account.bankaccount,uname,state,adate,versions FROM account,users 
			where account.bankaccount=users.bankaccount and account.bankaccount='$cardIdQuery'
		";
	}
	
	$resultSELECT = mysqli_query($conn,$sqlSELECT);
	  
	$arr = array(); 
	while($row = mysqli_fetch_array($resultSELECT)) { 
	  	$count=count($row);//不能在循环语句中，由于每次删除 row数组长度都减小 
	  	for($i=0;$i<$count;$i++){ 
	    	unset($row[$i]);//删除冗余数据 
		} 
	  
	  	array_push($arr,$row); 
	  
	} 
	$userdata=json_encode($arr,JSON_UNESCAPED_UNICODE);
	
	file_put_contents('userDatagrid.json', $userdata);

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
    			<div class="a1" style="position:absolute; left:12.5%; top:5%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="AdministratorBulletin.php"><font size="5%" face="STHeiTI">公告编辑</font></a>
				</div>
				<div class="a2" style="position:absolute; left:12.5%; top:15%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);background-color: #ffe48d;text-align:center;">
					<a style=" text-decoration: none;" href="UserManager.php"><font size="5%" face="STHeiTI">用户管理</font></a>
				</div>
				<div class="a3" style="position:absolute; left:12.5%; top:25%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="RichestList.php"><font size="5%" face="STHeiTI">富豪排行</font></a>
				</div>
				<div class="a4" style="position:absolute; left:12.5%; top:35%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="ChangePassword.php"><font size="5%" face="STHeiTI">修改密码</font></a>
				</div>
    	</div>
    	<div data-options="region:'center',border:false" style="background:#fff;padding: 10px;" >
			<table id="userTable" class="easyui-datagrid" style="width:100%;height:100%"
					url="userDatagrid.json"
					title="用户管理" toolbar="#search" singleSelect="true"
					rownumbers="true" pagination="true" fitColumns="true">
				<thead>
					<tr>
						<th field="ID" align="center">用户账号</th>
						<th field="bankaccount" align="center">银行卡号</th>
						<th field="uname" width="50" align="center">用户名</th>
						<th field="state" width="50" align="center">用户状态</th>
						<th field="adate" align="center">开户时间</th>
						<th field="versions" width="50" align="center">版本号</th>
						<th field="stateModify" width="50" align="center" formatter="formatAction">状态修改</th>
						<th field="passwordModify" width="50" align="center" formatter="passModifyAction">用户密码修改</th>
					</tr>
				</thead>
			</table>
			<div id="search" style="padding:3px">
				<span>银行卡号:</span>
				<input id="cardIdQuery" name="cardIdQuery" class="easyui-textbox" style="border:1px solid #ccc;border-radius: 5px;"></input>
				<button class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch();" >搜索</button>
			</div>
			
			<script type="text/javascript">
				//
				function formatAction(){
					var forbidden = '<button onclick="forbidden(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">禁用</button> ';
					var liftBan = '<button onclick="liftBan(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">解禁</button>';
					return forbidden+liftBan;
					
				}
				function passModifyAction(){
					var modify = '<button onclick="passModify(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">修改</button> ';
					return modify;
					
				}
				function forbidden(target){
					var row = $('#userTable').datagrid('getSelected');
					var bankaccount=row.bankaccount;
					var state=row.state;
					if (row){
						$.messager.alert('提示','你确定要禁用该用户吗？','info',
							function(){
								location.href='UserForbid.php?bankaccount='+bankaccount+'&state='+state;
							}
						);
					}
				}
				function liftBan(target){
					var row = $('#userTable').datagrid('getSelected');
					var bankaccount=row.bankaccount;
					var state=row.state;
					if (row){
						$.messager.alert('提示','你确定要解禁该用户吗？','info',
							function(){
								location.href='UserRelease.php?bankaccount='+bankaccount+'&state='+state;
							}
						);
					}
				}
				function passModify(target){
					var row = $('#userTable').datagrid('getSelected');
					var bankaccount=row.bankaccount;
					if (row){
						$('#passwordEdit').dialog('open');
					}
				}
				
				function doSearch(){
					cardIdQuery = $('#cardIdQuery').val();
					window.location.href='UserManager.php?cardIdQuery='+cardIdQuery;	
				}
			</script>
			
			<div id="passwordEdit" class="easyui-dialog" style="width:300px;height:240px;"title="编辑" iconCls="icon-edit" closed="true">
				<div style="margin-bottom:20px;margin-top: 10%;margin-left: 17%;">
					<input name="newPassword" id="newPassword" class="easyui-passwordbox" prompt="新密码" iconWidth="28" style="width:80%;height:34px;">
				</div>
				<div style="margin-bottom:20px;margin-top: 10%;margin-left: 17%;">
					<input name="passwordAgain" id="passwordAgain" class="easyui-passwordbox" prompt="再输一次" iconWidth="28" style="width:80%;height:34px;">
				</div>
				<div  style="margin-left: 35%;">
					<button style="width: 100px;height: 35px;font-size: 15px;
						border-radius: 5px;border:1px solid rgba(0,0,0,0);cursor:pointer;" onclick="validateForm()">保存</button>
				</div>
				<script>
					function validateForm(){
						var row = $('#userTable').datagrid('getSelected');
						var bankaccount=row.bankaccount;
						newPassword=$("#newPassword").val();
						passwordAgain=$("#passwordAgain").val();
						if(newPassword==null || newPassword==""){
							$.messager.alert('提示', '请填写新密码');
							return false;
						}
						else if(passwordAgain==null ||passwordAgain==""){
							$.messager.alert('提示', '请再次填写密码');
							return false;
						}
						else if(newPassword!=passwordAgain){
							$.messager.alert('提示', '两次新密码不一致');
							return false;
						}
						else{
							window.location.href='UserPassModifyByManager.php?bankaccount='+bankaccount+'&passwordAgain='+passwordAgain;
						}
					}
				</script>
			</div>
			
			<script>
				//打印表格和分页必须的函数
				function pagerFilter(data){
					if (typeof data.length == 'number' && typeof data.splice == 'function'){
						data = {
							total: data.length,
							rows: data
						}
					}
					var dg = $(this);
					var opts = dg.datagrid('options');
					var pager = dg.datagrid('getPager');
					pager.pagination({
						onSelectPage:function(pageNum, pageSize){
							opts.pageNumber = pageNum;
							opts.pageSize = pageSize;
							pager.pagination('refresh',{
								pageNumber:pageNum,
								pageSize:pageSize
							});
							dg.datagrid('loadData',data);
						}
					});
					if (!data.originalRows){
						data.originalRows = (data.rows);
					}
					var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
					var end = start + parseInt(opts.pageSize);
					data.rows = (data.originalRows.slice(start, end));
					return data;
				}
				$(function(){
					$('#userTable').datagrid({loadFilter:pagerFilter}).datagrid('loadData');
				});
			</script>
			

    	</div>
	</body>
</html>

<?php
	//$bankaccount="<script>document.writeln(bankaccount);</script>";
//	$bankaccount=$_POST['bankaccount'];  
//
//	$newPassword=$_POST['newPassword'];
//	echo '<div style="position:absolute; left:65%; top:55%;color:red;font-size: 75%;"><div>'.$bankaccount;
//	echo '<div style="position:absolute; left:65%; top:60%;color:red;font-size: 75%;"><div>'.$newPassword;
//	$sqlPASS="SELECT * FROM account WHERE bankaccount ='$bankaccount'";
//	$resultPASS=mysqli_query($conn, $sqlPASS);
//	echo '<div style="position:absolute; left:65%; top:60%;color:red;font-size: 75%;"><div>'.mysqli_num_rows($resultPASS);
//	if((mysqli_num_rows($resultPASS) > 0)&&!($newPassword==null||$newPassword=="")){
//		mysqli_query($conn, "UPDATE account SET upassword='$newPassword' where bankaccount ='$bankaccount'");
//		echo"<script type='text/javascript'>$.messager.alert('', '修改成功!','info');</script>";
//	}
//	elseif((mysqli_num_rows($resultPASS) == 0)&&!($newPassword==null||$newPassword=="")){
//		echo"<script type='text/javascript'>$.messager.alert('', '修改失败!','info');</script>";
//	}
?>