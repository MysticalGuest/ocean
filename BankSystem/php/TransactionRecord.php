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
	
	$sql = "SELECT * FROM dealdetail where senaccount='$cardId' or recaccount='$cardId'"; 
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
	
	file_put_contents('transactionDatagrid.json', $data);
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

    	<div data-options="region:'west',border:true,split:false,collapsible:false" style="width:200px; background-color: #f8f8f8; border:2px solid grey;">
    			<div class="a1" style="position:absolute; left:12.5%; top:5%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="CapitalOperation.php"><font size="5%" face="STHeiTI">资金操作</font></a>
				</div>
    			<div class="a2" style="position:absolute; left:12.5%; top:15%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);background-color: #ffe48d;text-align:center;">
					<a style=" text-decoration: none;" href="TransactionRecord.php"><font size="5%" face="STHeiTI">交易记录</font></a>
				</div>
				<div class="a3" style="position:absolute; left:12.5%; top:25%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="PersonalInformation.php"><font size="5%" face="STHeiTI">个人信息</font></a>
				</div>
				<div class="a4" style="position:absolute; left:12.5%; top:35%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="InfoManagement.php"><font size="5%" face="STHeiTI">信息管理</font></a>
				</div>
    		
    	</div>
    	<div data-options="region:'center',border:true,title:'交易记录'" style="background:#fff;" >
    		<div style="width:100%;height:100%;float: right;padding: 5px;">
    			<table id="dealTable" class="easyui-datagrid" style="width:100%;height:100%"
    				fitColumns="true" data-options="
						rownumbers:true,
						singleSelect:true,
						autoRowHeight:false,
						pagination:true,
						pageSize:10,
						url:'transactionDatagrid.json'">
					<thead>
						<tr>
							<th field="dealID" width="50" align="center">交易单号</th>
							<th field="hdate" width="50" align="center">交易时间</th>
							<th field="recaccount" width="50" align="center">转入账号</th>
							<th field="senaccount" width="50" align="center">转出账号</th>
							<th field="money" width="50" align="center">交易金额(元)</th>
						</tr>
					</thead>
				</table>
				<script>
					//打印表格和分页必须的函数
//					function pagerFilter(data){
//						if (typeof data.length == 'number' && typeof data.splice == 'function'){
//							data = {
//								total: data.length,
//								rows: data
//							}
//						}
//						var dg = $(this);
//						var opts = dg.datagrid('options');
//						var pager = dg.datagrid('getPager');
//						pager.pagination({
//							onSelectPage:function(pageNum, pageSize){
//								opts.pageNumber = pageNum;
//								opts.pageSize = pageSize;
//								pager.pagination('refresh',{
//									pageNumber:pageNum,
//									pageSize:pageSize
//								});
//								dg.datagrid('loadData',data);
//							}
//						});
//						if (!data.originalRows){
//							data.originalRows = (data.rows);
//						}
//						var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
//						var end = start + parseInt(opts.pageSize);
//						data.rows = (data.originalRows.slice(start, end));
//						return data;
//					}
					$(function(){
						$('#dealTable').datagrid({loadFilter:pagerFilter}).datagrid('loadData');
					});
				</script>
				
			</div>
    	</div>		
	</body>
</html>