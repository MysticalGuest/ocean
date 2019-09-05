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
    
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<link rel="stylesheet" type="text/css" href="css/fontStyle.css"/>
	<link rel="stylesheet" type="text/css" href="css/CustomerInfoStyle.css"/>
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="easyui/locale/easyui-lang-zh_CN.js"></script>
  </head>
  
  <body id="allBody" name="allBody" class="easyui-layout">
  	<!--上-->
 	<div data-options="region:'north',border:false," style="background:#fff;height:20%;" >
		<div style="position:absolute; left:45%; top:20%;">
			<font style="font-family:HYChaoJiZhanJiaW;font-size:50px;color: black;">
				尊品360宾馆服务平台
			</font>
		</div>
		<div style="position:absolute; left:18%; top:8%;">
			<img src="img/360black.png" width="65%">
		</div>
	</div>
 	<!--西-->
   	<div data-options="region:'west',border:false," style="background:#fff;width:20%;" >
		<form id="searchForm" action="" method="post">
   			<div id="search" style="padding:3px;background-color: #00B4FA;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;">
   				<input id="roomNum" name="roomNum" class="easyui-textbox" 
   				style="border:1px solid #ccc;border-radius: 5px;" data-options="prompt:'根据房号查询:'"></input>
   			</div>
   			<div id="search" style="padding:3px;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
   				<input id="price" name="price" class="easyui-combogrid" data-options="
   	          		width:'90%',
   					panelHeight:'auto',
   					idField:'num',
   					textField:'price',
   					mode:'remote',
   					fitColumns:true,
   					editable : false,
   					columns:[[
   						{field:'num',title:'序号',width:'50%'},
   						{field:'price',title:'房价',width:'50%'}
   					]],
   					prompt:'根据价格查询:',
   	          		">
   	           	<input name="forPrice" id="forPrice" type="hidden" />
   			</div>
   			<div id="search" style="color:white;padding:3px;background-color: #00B4FA;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
   				根据房间状态查询:<br>
   				已开出<input name="state" type="radio" value="true">
   				未开出<input name="state" type="radio" value="false">
   				<input name="forState" id="forState" type="hidden" />
   			</div>
   	       	<script>
   	       		//房价树形下拉框-
   	       		var dataPrice='<%=session.getAttribute("jsonPrice")%>';
   				price= JSON.parse(dataPrice);
   				$(function(){
   		    		$("#price").combogrid({
   		                data: price,
   		            });
   		    	});
   			</script>
		</form>
		<div id="search" style="padding:3px;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
			<button class="easyui-linkbutton" iconCls="icon-search" onclick="ApartmentSearch();" style="width: 95%;">搜索</button>
		</div>
		<div id="showAll" style="padding:3px;background-color: #00B4FA;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
			<button class="easyui-linkbutton"  onclick="showAll()" style="width: 95%;">显示全部</button>
			<input name="isShowAll" id="isShowAll" type="hidden" />
		</div>
		<script>
			function ApartmentSearch(){
				var roomNum=document.getElementById('roomNum').value;
				var num=$("#price").combogrid("getValues");
				var selectPrice='';
				for(var i=0; i<price.length; i++){
					if(num==price[i].num){
						selectPrice=price[i].price;
						break;
					}
				}
				var state=$('input:radio:checked').val();
				if(state!='true'&&state!='false'){
					var state="";
					
				}
				if(roomNum==""&&selectPrice==""&&state==""){
					$.messager.alert('提示','您未填写任何查询项！','warning') 
				}
				else{
					$.ajax({
						url:'../administrator/ApartmentSearch',
						data:{'roomNum':roomNum,'selectPrice':selectPrice,'state':state},
						type:'post',//HTTP请求类型
						success:function(data){
							$.messager.alert('提示','查询成功！','info',
								function(){
									$("#roomNum").val(roomNum);
									$("#price").val(selectPrice);
									$("#state").val(state);
									$("#searchForm").attr("action","../administrator/ApartmentManageAdm");
									$("#searchForm").submit();
								}
							)
						},
						error:function(xhr,type,errorThrown){
							
						}
					});
				}
				
			}
			
			//显示全部,将所有输入置空
			function showAll(){
				$.ajax({
					url:'../administrator/ApartmentSearch',
					data:{'roomNum':"",'selectPrice':"",'state':""},
					type:'post',//HTTP请求类型
					success:function(data){
						$.messager.alert('提示','查询成功！','info',
							function(){
								$("#roomNum").val("");
								$("#price").val("");
								$("#state").val("");
								$("#searchForm").attr("action","../administrator/ApartmentManageAdm");
								$("#searchForm").submit();
							}
						)
					},
					error:function(xhr,type,errorThrown){
						
					}
				});
			}
		</script>
   		<div style="padding:3px;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
   			<button class="easyui-linkbutton"  onclick="checkOutChecked();" style="width: 95%;">多选退房</button>
   		</div>
   		<div style="padding:3px;background-color: #00B4FA;border: 1px solid #B2D7F2;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;margin-top: 10%;">
   			<button class="easyui-linkbutton"  onclick="allCheckOut();" style="width: 95%;">全部退房</button>
   		</div>
   		<script>
   			//全部退房调用函数
   	    	function allCheckOut(){
   	    		var flag="adm";
   				$.ajax({
   	               	url: '../administrator/allCheckOut',
   	               	type: 'post',
   	               	data: {'flag':flag},
   	               	traditional:true,//用传统方式序列化数据
   	               	success:function(){
   	                	$.messager.alert('提示','全部退房成功！','info',
   	                		function(){
   								location.href='../administrator/ApartmentManageAdm'
   							}
   	                	)          
   	               	}
   	           	});
   	    	}
   	    	//多选退房
   	    	function checkOutChecked(){
   	    		var flag="adm";
   	    		var checkedItems = $('#apartment').datagrid('getChecked');
   	    		var rooms = [];
   				$.each(checkedItems, function (index, item) {
   					rooms.push(item.roomNum);
   				});
   				//将rooms数组转为字符串传到后台
   				var strRoom=rooms.join(",")
   				if(rooms==""){
   					$.messager.alert('提示','您未选中任何房间！','warning');
   				}
   				else{
   					// alert(strRoom);
   					$.ajax({
						url: '../administrator/checkOutChecked',
						type: 'post',
						data: {'flag':flag,'strRoom':strRoom},
						traditional:true,//用传统方式序列化数据
						success:function(){
							$.messager.alert('提示','选中退房成功！','info',
								function(){
									location.href='../administrator/ApartmentManageAdm'
								}
							)          
						}
					});
   				}
   				
   	    	}
   		</script>
	</div>
	
	<!--东-->
	<div data-options="region:'east',border:false," style="background:#fff;width:20%;" >
		<div id="search" style="padding:3px;background-color: #00B4FA;border-radius: 5px;width: 80%;padding-left:5%;margin-left: 10%;">
			<input id="priceChecked" name="priceChecked" class="easyui-textbox" 
			style="border:1px solid #ccc;border-radius: 5px;" data-options="prompt:'填写修改多间客房房价:'"><font style="color: white;">元</font></input>
			<button class="easyui-linkbutton"  onclick="resetPriceChecked();" style="width: 95%;margin-top: 10px;">修改房价</button>
			<script>
				function resetPriceChecked(){
					var price=document.getElementById('priceChecked').value;
					var checkedItems = $('#apartment').datagrid('getChecked');
					var rooms = [];
					$.each(checkedItems, function (index, item) {
						rooms.push(item.roomNum);
					});
					//将rooms数组转为字符串传到后台
					var strRoom=rooms.join(",")
					if(rooms==""){
						$.messager.alert('提示','您未选中任何房间！','warning');
					}
					else if(price==""){
						$.messager.alert('提示','您未填写房价！','warning');
					}
					else{
						// alert(strRoom);
						$.ajax({
							url: '../administrator/resetPriceChecked',
							type: 'post',
							data: {'strRoom':strRoom,'price':price},
							traditional:true,//用传统方式序列化数据
							success:function(){
								$.messager.alert('提示','修改成功！','info',
									function(){
										location.href='../administrator/ApartmentManageAdm'
									}
								)          
							}
						});
					}
					
				}
			</script>
		</div>
		<div class="main-box" style="padding-top: 10%;">
			<ul class="index-tserver">
				<li class="tserver-list1">
					返回首页
					<p class="animated zoomin">
						<a href="administrator/HomeForAdm">返回首页，执行其他选项操作</a>
					</p>
				</li>
				<li class="tserver-list2">
					敬请期待
					<p class="animated zoomin">
						<a href="#"></a>
					</p>
				</li>
			</ul>
		</div>
	</div>
   	
   	<!--中-->
   	<div data-options="region:'center',border:true,title:'客房管理'" style="background:#fff;" >
   		<div style="width:100%;height:100%;float: right;padding: 5px;">
   			<table id="apartment" class="easyui-datagrid" style="width:100%;height:100%"
   				fitColumns="true" idField="roomNum" data-options="
					rownumbers:true,
					autoRowHeight:true,
					pagination:true,
					pageSize:10">
				<thead>
					<tr>
						<th field="ck" checkbox="true"></th>
						<th field="roomNum" width="50" align="center">房号</th>
						<th field="price" width="50" align="center" editor="numberbox">价格</th>
						<th field="state" width="50" align="center">房间状态</th>
						<th field="action" width="50" align="center" formatter="formatAction">修改</th>
						
					</tr>
				</thead>
			</table>
			
			<script type="text/javascript">
				function formatAction(value,row,index){
					if (row.editing){
						var save = '<button onclick="saverow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">保存</button> ';
						var cancel = '<button onclick="cancelrow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">取消</button>';
						return save+cancel;
					} else {
						var edit = '<button onclick="editrow(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">编辑</button> ';
						var checkOut = '<button onclick="checkOut(this)" style="cursor:pointer;border:1px solid #ccc;border-radius: 2px;">退房</button>';
						if(row.state=="未开出")
							return edit;
						else if(row.state=="已开出")
							return edit+checkOut;
					}
					
				}
				
				$(function(){
					$('#apartment').datagrid({
						onBeforeEdit:function(index,row){
							$(this).datagrid('updateRow', {index:index,row:{editing:true}})
						},
						onAfterEdit:function(index,row){
							$(this).datagrid('updateRow', {index:index,row:{editing:false}})
						},
						onCancelEdit:function(index,row){
							$(this).datagrid('updateRow', {index:index,row:{editing:false}})
						}
					});
				});
				function getRowIndex(target){
					var tr = $(target).closest('tr.datagrid-row');
					return parseInt(tr.attr('datagrid-row-index'));
				}
				function editrow(target){
					$('#apartment').datagrid('beginEdit', getRowIndex(target));
				}
				function checkOut(target){
					var flag="adm";
					var row = $('#apartment').datagrid('getSelected');
					var roomNum=row.roomNum;
					if (row){
						$.ajax({
	                    	url: '../administrator/checkOut',
	                    	type: 'post',
	                    	data: {'roomNum':roomNum,'flag':flag},
	                    	traditional:true,//用传统方式序列化数据
	                    	success:function(){
		                    	$.messager.alert('提示','退房成功！','info',
		                    		function(){
										location.href='../administrator/ApartmentManageAdm'
									}
		                    	)             
	                    	}
	                	});
					}
				}
				function saverow(target){
					$('#apartment').datagrid('endEdit', getRowIndex(target));
					var row = $('#apartment').datagrid('getSelected');
					var price=row.price;
					var roomNum=row.roomNum;
					if (row){
						$.ajax({
	                    	url: '../administrator/ResetPrice',
	                    	type: 'post',
	                    	data: {'roomNum':roomNum,'price':price},
	                    	traditional:true,//用传统方式序列化数据
	                    	success:function(){
		                    	$.messager.alert('提示','修改成功！','info',
		                    		function(){
										location.href='../administrator/ApartmentManageAdm'
									}
		                    	)             
	                    	}
	                	});
					}
				}
				function cancelrow(target){
					$('#apartment').datagrid('cancelEdit', getRowIndex(target));
				}
				$('#apartment').datagrid('selectRow',index);
				$('#apartment').datagrid('beginEdit',index);
			</script>
			
			<script>
				function getData(){
					var state='';
					var rows = [];
					var jsondata='<%=session.getAttribute("jsonROOM")%>';
					data= JSON.parse(jsondata);
					for(var i=0; i<data.length; i++){
						if(data[i].state==false)
							state="未开出";
						else if(data[i].state==true)
							state="已开出";
						rows.push({
							roomNum: data[i].roomNum,
							price: data[i].price,
							state: state,
						});
					}
					return rows;
				}
	
				function pagerFilter(data){
					if (typeof data.length == 'number' && typeof data.splice == 'function'){	// is array
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
					$('#apartment').datagrid({loadFilter:pagerFilter}).datagrid('loadData', getData());
				});
			</script>
		</div>
   	</div>
   	
  </body>
</html>
