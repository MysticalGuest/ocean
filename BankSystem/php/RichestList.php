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
	
	$sql = "SELECT uname,banlance FROM account,users WHERE account.bankaccount=users.bankaccount order by banlance desc limit 0,10"; 
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
	
	file_put_contents('RichTOP10.json', $data);
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
		<script src="../easyui/echarts.js"></script>
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
							<a class="a" href="登录.html" style=" text-decoration: none;">退出</a> 
						</div>
					</div>
				</div>
   			</div>
   		</div>

    	<div data-options="region:'west',border:true,split:false,collapsible:false" style="width:200px; background-color: #f8f8f8; border:2px solid grey;">
    			<div class="a1" style="position:absolute; left:12.5%; top:5%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="AdministratorBulletin.php"><font size="5%" face="STHeiTI">公告编辑</font></a>
				</div>
				<div class="a2" style="position:absolute; left:12.5%; top:15%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="UserManager.php"><font size="5%" face="STHeiTI">用户管理</font></a>
				</div>
				<div class="a3" style="position:absolute; left:12.5%; top:25%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);background-color: #ffe48d;text-align:center;">
					<a style=" text-decoration: none;" href="RichestList.php"><font size="5%" face="STHeiTI">富豪排行</font></a>
				</div>
				<div class="a4" style="position:absolute; left:12.5%; top:35%;padding:5%;width:75%;border-radius:10px; border:1px solid rgba(0,0,0,0);text-align:center;">
					<a style=" text-decoration: none;" href="ChangePassword.php"><font size="5%" face="STHeiTI">修改密码</font></a>
				</div>
    	</div>
    	<div data-options="region:'center',title:'富豪排行',border:false" style="background:#fff;" >
    		
    		<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
		    <div id="chart" style="width: 70%;height:400px;margin-left: 5%;top:10%"></div>
		    <script type="text/javascript">
		        // 基于准备好的dom，初始化echarts实例
		        //var myChart = echarts.init(document.getElementById('chart'));
		        
		 		function DrawEChart() {
		 			// 基于准备好的dom，初始化echarts实例
		            //--- 折柱 ---
		            var myChart = echarts.init(document.getElementById('chart'));
		            //显示标题，图例和空的坐标轴
    				var series = [];
    				//指定图表的配置项和数据
    				myChart.setOption({
				        color : ["#26aa1b"],
				        title: {
				            text: '富豪榜TOP10'
				        },
				        tooltip: {
		                    //trigger: 'axis'
		                },
				        legend: {
				            data: ["金额"]
				        },
//		                toolbox: {
//		                    show: true,
//		                    feature: {
//		                        mark: false
//		                    }
//		                },
//		                calculable: true,
				        xAxis: [{
//		                        type: 'category',
		                        data: []
		                    }
		                ],
				        yAxis: {
//				            splitLine: { show: false },//去除网格线
//				            name: ''
//		                    {
//		                        type: 'value',
//		                        splitArea: { show: true }
//		                    }
							title:{
		            			text:'金额',
		            		}
				        },
				        series: [{
		                    name: '金额',
		                    type: 'bar',
		                    data:[]
		                }]
				    });
		            //图表显示提示信息
		            myChart.showLoading({
		                text: "图表数据正在努力加载..."
		            });
		            var uname = [];    //类别数组（实际用来盛放X轴坐标值）
		            //通过Ajax获取数据
		            $.ajax({
		                type: "GET",
//		                async: false, //同步执行
		                url: "RichTOP10.json",
		                dataType: "json", //返回数据形式为json
		                success: function (result) {
		                	//请求成功时执行该函数内容，result即为服务器返回的json对象
		                    $.each(result, function (index, item) {
				                uname.push(item.uname);    //挨个取出类别并填入类别数组
				                series.push(item.banlance);
				            });
		                    myChart.hideLoading();    //隐藏加载动画
				            myChart.setOption({        //加载数据图表
				                xAxis: {
				                    data: uname
				                },
				                series: [{                    
				                    data: series
				                }]
				            });
		                },
		                error: function (errorMsg) {
		                    alert("图表请求数据失败啦!");
		                }
		            });
			        //myChart.setOption(option);
		        };
		        DrawEChart()
		    </script>
    		
    		
    	</div>
	</body>
</html>


<?php

?>