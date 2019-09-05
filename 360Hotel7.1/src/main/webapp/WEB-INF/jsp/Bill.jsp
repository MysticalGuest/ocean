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
	<link rel="shortcut icon" href="img/fbadge.ico"  type="image/x-icon"/>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="easyui/locale/easyui-lang-zh_CN.js"></script>
	
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
		a.a:link {color: white}
		a.a:visited {color: white}
		a.a:hover {color:grey}
		a.a:active {color: white}
	</style>
	

  </head>
  
  <body>
    	<form id="BillForm" action="administrator/Bill" method="post">
			<table width="920" border="1" cellpadding="7" cellspacing="1" align="center" 
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
		            	<div name="cName" id="cName" contenteditable="true" style="width:80px;height:25px;"></div>
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
		            	<input name="forRoom" id="forRoom" type="hidden" οninput="OnInput (event)" onpropertychange="OnPropChanged (event)" />
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
		            <td align="center" valign="middle"colspan="2" style="border-left: none;"><strong>日住全天房：</strong></td>
		            <td align="center" rowspan="2"><div id="nowtime"></div></td>
		            <td align="center"><div contenteditable="true" style="width:50px;height:25px;"></div></td>
		            <td align="center"><div contenteditable="true" style="width:50px;height:25px;float: left;"></div>元</td>
		            <td align="center" style="border-right: none;">间</td>
		            <td align="center" style="border-right: none;">元</td>
		            <td align="center" colspan="4" style="border-left: none;border-right: none;"></td>
		        </tr>
		        <tr>
		        	
		            <td align="center" valign="middle"colspan="2" style="border-left: none;"><strong>日住钟点房：</strong></td>
		            <td align="center"><div contenteditable="true" style="width:50px;height:25px;"></div></td>
		            <td align="center"><div contenteditable="true" style="width:50px;height:25px;float: left;"></div>元</td>
		            <td align="center" style="border-right: none;">间</td>
		            <td align="center" style="border-right: none;">元</td>
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
	            }
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
	        </script>
	        
		    
		    <!--将div的数据存入input传给后台-->
		    <script>
		    	function formSubmit(){
		    		var cName = $("#cName").html();
	                $("#forcName").val(cName);
					var roomNum=$("#roomSelect").combogrid("getValues");
					$("#forRoom").val(roomNum);
		    		var myform=$('#BillForm'); //得到form对象
	  				//实现打印后保存
	                window.print();
	        		myform.submit();
	        		
		    	}
		    </script>
		    
		    <!--打印的时候将按钮隐藏-->
		    <script>
				function hide(){
					document.getElementById('returnHome').style.display='none';
					document.getElementById('print').style.display='none';
				};
			</script>
		    <div id="returnHome" style="position: absolute;left: 20%;padding-top:6%">
		   		<a href="../administrator/CustomerInfoForFront" style="text-decoration: none;padding:11px 18px;
					border-radius:3px; border:1px grey; background-color: grey; color:white;cursor:pointer;">
					返回首页
				</a>
		   	</div>
		    <div id="print" style="position: absolute;left: 70%;padding-top:6%">
		   		<button onclick="hide();formSubmit();" style="width:80px;height:35px;
					border-radius:3px; border:1px grey; background-color: grey; color:white;cursor:pointer;float: right;">
					打印
				</button>
		   	</div>
    	</form>
  </body>
</html>
