<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE HTML>
<html>
<head>
    <base href="<%=basePath%>">
    
    <meta http-equiv="content-type" content="text/html" charset="utf-8">
	<title>尊品360宾馆管理系统</title>
	<link rel="shortcut icon" href="img/fire.ico"  type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/BillButton.css"/>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="easyui/locale/easyui-lang-zh_CN.js"></script>
</head>
  
	<body>
    	<form id="BillForm" action="administrator/Bill" method="post">
			<table width="850" border="1" cellpadding="7" cellspacing="1" align="center" 
				style="border-left: none;border-right: none;border-top: none;">
		        <tr>
		            <td colspan="11" align="center" style="text-align: center; font-weight: bold;
		                font-size: 35px;border-left: none;border-top: none;border-right: none;">尊品360宾馆欢迎您！</td>
		        </tr>
		        <tr>
		            <td align="center" valign="middle" colspan="2" style="border-left: none;border-right: none;"><strong>日期：</strong></td>
		            <td align="center" colspan="2" style="border-left: none;"><div id="nowdate"></div></td>
		            <td align="center" style="border-right: none;"><strong>客人姓名：</strong></td>
		            <td align="center" style="border-left: none;">
		            	<div name="cName" id="cName" contenteditable="true" style="width:60px;height:25px;"></div>
		            	<input  type="hidden" name="forcName" id="forcName" />
					</td>
		            <td align="center" style="border-right: none;"><strong>房号：</strong></td>
		            <td align="center" colspan="2" style="border-left: none;" >
		            	<input id="roomSelect" name="roomSelect" class="easyui-combogrid" style="width:150px;" data-options="
		            			width:'100%',
								panelHeight:'auto',
								idField:'roomNum',
								textField:'roomNum',
								mode:'local',
								fitColumns:true,
								editable : false,//不可编辑
								multiple:true,
								multiline:true,
								pagination:true,
								columns:[[
									{field:'roomNum',title:'房号',width:'50%'},
									{field:'price',title:'房价',width:'50%'}
								]],
								
		            		">
		            	<input name="forRoom" id="forRoom" type="hidden" />
		            	<!--房号树形下拉框-->	
		            	<script>
		            		var dataROOM='<%=session.getAttribute("jsonROOM")%>';
		    				data= JSON.parse(dataROOM);
							$(function(){
					    		$("#roomSelect").combogrid({
					                data: data,
					            });
					    	});
						</script>
						
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
									showPageList: false,
									displayMsg: '',
									layout:['first','prev','next','last'],
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
								$('#roomSelect').combogrid({loadFilter:pagerFilter}).datagrid('loadData');
							});
						</script>
		            </td>
		            <td align="center" valign="middle" style="border-right: none;"><strong>操作员：</strong></td>
		            <td align="center" name="operator" style="border-right: none;border-left: none;">${thisadministrator.aName}</td>
		        </tr>
		        <tr>
		            <td align="center" valign="middle" colspan="2" style="border-left: none;"><strong>记账项目</strong></td>
		            <td align="center"><strong>入住时间</strong></td>
		            <td align="center"><strong>总计天数</strong></td>
		            <td align="center"><strong>房间价格</strong></td>
		            <td align="center"><strong>数量</strong></td>
		            <td align="center"><strong>押金</strong></td>
		            <td align="center" colspan="4" style="border-right: none;"><strong>其他消费</strong></td>
		        </tr>
		        <tr>
		            <td align="center" valign="middle"colspan="2" style="border-left: none;"><input name="roomType" type="radio" checked="checked" value="allDay"/><strong>日住全天房：</strong></td>
		            <td align="center" rowspan="2"><div id="nowtime"></div></td>
					<!-- 总计天数 -->
		            <td align="center"><input type="number" min="0" style="width: 30px;border-style: none;"></td>
					<!-- 房间价格 -->
		            <td align="center"><div id="sumOfPrice1" style="width: 20px;display: inline;"></div>元</td>
					<!-- 数量 -->
		            <td align="center" style="border-right: none;"><div id="sumOfRooms1" style="width: 20px;display: inline;"></div>间</td>
					<!-- 押金 -->
		            <td align="center" style="border-right: none;"><div id="deposit1" style="width: 20px;display: inline;"></div>元</td>
		            <td align="center" colspan="4" style="border-left: none;border-right: none;"></td>
		        </tr>
		        <tr>
		        	
		            <td align="center" valign="middle"colspan="2" style="border-left: none;"><input name="roomType" type="radio" value="hour"/><strong>日住钟点房：</strong></td>
					<!-- 总计天数 -->
		            <td align="center"><input type="number" min="0" style="width: 30px;border-style: none;"></td>
					<!-- 房间价格 -->
		            <td align="center"><div id="sumOfPrice2" style="width: 20px;display: inline;"></div>元</td>
					<!-- 数量 -->
		            <td align="center" style="border-right: none;"><div id="sumOfRooms2" style="width: 20px;display: inline;"></div>间</td>
					<!-- 押金 -->
		            <td align="center" style="border-right: none;"><div id="deposit2" style="width: 20px;display: inline;"></div>元</td>
		            <td align="center" colspan="4" style="border-left: none;border-right: none;"></td>
		        </tr>
		        <tr>
		        	<td align="center" colspan="2" style="border-left: none;border-right: none;"><strong>房费和押金：</strong></td>
		        	<td align="center" style="border-left: none;"><div id="chargeAndDeposit" contenteditable="true" style="width:40px;height:25px;float: left;">200</div>元</td>
		        	<td colspan="3"></td>
		        	<td align="center" colspan="5" style="border-right: none;"><strong>欢迎光临尊品360宾馆！</strong></td>
		        	
		        </tr>
		        <tr>
		        	<td align="center" colspan="1" style="border-left: none;border-right: none;"><strong>地址：</strong></td>
		        	<td align="center" colspan="4" style="border-left: none;">湖北省襄阳市襄州区航空路铁十一局旁</td>
		        	<td align="center" colspan="1" style="border-right: none;"><strong>服务电话：</strong></td>
		        	<td align="center" style="border-left: none;">0710-2919966</td>
		        	<td align="center" colspan="4" style="border-right: none;"><strong>欢迎再次光临尊品360宾馆！</strong></td>
		        </tr>
		
		   	</table>   	
		   	
		    <!--加载时间的函数-->
		    <script>
	            //页面加载调用
	            window.onload=function(){
	                //每1秒刷新时间
					setInterval("NowTime()",1000);
	            }
	            function NowTime(){
	                //获取年月日
	                var time=new Date();
	                var year=time.getFullYear();
	                //月份是从0开始计算的，取值为0-11，所以会小1
	                var month=time.getMonth()+1;
	                var day=time.getDate();
	                
	                //获取时分秒
	                var h=time.getHours();
	                var m=time.getMinutes();
	                var s=time.getSeconds();
	                
	                //检查是否小于10
	                h=check(h);
	                m=check(m);
	                s=check(s);
	                document.getElementById("nowtime").innerHTML=h+":"+m+":"+s;
	                document.getElementById("nowdate").innerHTML=year+"-"+month+"-"+day;
					
					//时间数字小于10，则在之前加个“0”补位。
					function check(i){
					    //方法一，用三元运算符
					    var num;
					    i<10?num="0"+i:num=i;
					    return num;
					    
					    //方法二，if语句判断
					    //if(i<10){
					    //    i="0"+i;
					    //}
					    //return i;
					}
					
					//根据房间combogrid输出房间数
					var count=0;
					var arr=[];    //定义一个数组存放判断后不重复的元素
					// var forRoomVal=document.getElementById('forRoom').value;
					var roomNum=$("#roomSelect").combogrid("getValues");
					//由于combogrid换页产生的数据重复,以此方法去除数组中重复元素
					for(var i = 0; i < roomNum.length; i++){    //循环遍历当前数组  
						//判断当前数组下标为i的元素是否已经保存到临时数组  
						//如果已保存，则跳过，否则将此元素保存到临时数组中  
						if(arr.indexOf(roomNum[i])==-1){  
							arr.push(roomNum[i]);
							count++;
						}  
					}
					$("#forRoom").val(arr);
					
					//根据房间combogrid输出房价
					var type=$("input[name='roomType']:checked").val();
					var dataROOM='<%=session.getAttribute("jsonROOM")%>';
					data= JSON.parse(dataROOM);
					var price=0;
					for(var i=0;i<arr.length; i++){
						for(var j=0;j<data.length; j++){
							if(data[j].roomNum==arr[i]){
								if(type=="hour"){
									price+=50;
								}
								else{
									price+=data[j].price;
								}
								break;
							}
								
						}
					}
					
					//计算押金
					var chargeAndDeposit = $("#chargeAndDeposit").html();
					
					if(type=="allDay"){
						document.getElementById("sumOfRooms1").innerHTML=count;
						document.getElementById("sumOfPrice1").innerHTML=price;
						document.getElementById("deposit1").innerHTML=chargeAndDeposit-price;
						document.getElementById("sumOfRooms2").innerHTML='';
						document.getElementById("sumOfPrice2").innerHTML='';
						document.getElementById("deposit2").innerHTML='';
					}
					else if(type=="hour"){
						document.getElementById("sumOfRooms1").innerHTML='';
						document.getElementById("sumOfPrice1").innerHTML='';
						document.getElementById("deposit1").innerHTML='';
						document.getElementById("sumOfRooms2").innerHTML=count;
						document.getElementById("sumOfPrice2").innerHTML=price;
						document.getElementById("deposit2").innerHTML=chargeAndDeposit-price;
					}
					else{}
					
	            }
	            
	        </script>
    	</form>
		<!--将div的数据存入input传给后台-->
		<script>
			function formSubmit(){
				var cName = $("#cName").html();
		        $("#forcName").val(cName);
				var myform=$('#BillForm'); //得到form对象
				//实现打印后保存
		        window.print();
				myform.submit();
				
			}
			//打印的时候将按钮隐藏
			function hide(){
				document.getElementById('button').style.display='none';
			};
		</script>
		<div id="button" class="main-box">
			<ul class="index-tserver">
				<li class="tserver-list1">
					顾客信息统计
					<p class="animated zoomin">
						<a href="administrator/Home">返回首页，执行其他选项操作</a>
					</p>
				</li>
				<li class="tserver-list2">
					打印发票
					<p class="animated zoomin">
						<a onclick="hide();formSubmit();">点击打印发票</a>
					</p>
				</li>
			</ul>
		</div>
  </body>
</html>
