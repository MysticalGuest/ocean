package com.hotel.controllers;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.apache.ibatis.annotations.Param;
import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;

import com.hotel.entity.Administrator;
import com.hotel.entity.Apartment;
import com.hotel.entity.Customer;
import com.alibaba.druid.sql.ast.statement.SQLIfStatement.Else;
import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.github.pagehelper.PageHelper;
import com.github.pagehelper.PageInfo;
import com.hotel.controllers.AdministratorController;
import com.hotel.serviceimpl.AdministratorServiceImpl;
import com.hotel.serviceimpl.ApartmentServiceImpl;
import com.hotel.serviceimpl.CustomerServiceImpl;

@Controller
@RequestMapping("administrator")
public class AdministratorController {
	private static final Logger LOG = Logger.getLogger(AdministratorController.class);
	@Autowired
	private AdministratorServiceImpl administratorServiceimpl;
	
	@Autowired
	private CustomerServiceImpl customerServiceimpl;
	
	@Autowired
	private ApartmentServiceImpl apartmentServiceimpl;
	
	@RequestMapping(value = "/hello")
	@ResponseBody
	public String hello() {
		System.out.println("hello...");
		return "hello,user";
	}
	
	@RequestMapping(value="/Bill",method = RequestMethod.GET)
	public String Bill(HttpSession session) throws JsonProcessingException{
		LOG.info("bill...");
		List<Apartment> apartmentList = apartmentServiceimpl.getSpareApartment();
		List<Apartment> apartmentJSON = new ArrayList<Apartment>();
		for (int i = 0; i < apartmentList.size(); i++){
			Apartment apartment = new Apartment();
			apartment.setroomNum(apartmentList.get(i).getroomNum());
			apartment.setPrice(apartmentList.get(i).getPrice());
			apartmentJSON.add(apartment);
		}
		ObjectMapper mapperROOM = new ObjectMapper();
		String jsonROOM = mapperROOM.writeValueAsString(apartmentJSON);
		session.setAttribute("jsonROOM", jsonROOM);
		System.out.println(jsonROOM);
		return "Bill";
	}
	
	//传数据
	@RequestMapping(value="/Bill",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String BillPOST(Customer customer,HttpServletRequest request,HttpSession session){
		LOG.info("billPOST...");
		String cName = request.getParameter("forcName");
		customer.setcName(cName);
		String room = request.getParameter("forRoom");
		customer.setroomNum(room);
		System.out.println("Room is :"+room);
		List<Apartment> apartmentList = apartmentServiceimpl.getAllApartment();
		String[] roomArray = room.split(","); // 用,分割
		for(String roomNum:roomArray){
			System.out.println(roomNum);
			LOG.info("CheckIn...");
			Apartment thisapartment = new Apartment();
			for (int i = 0; i < apartmentList.size(); i++){
				if(apartmentList.get(i).getroomNum().equals(roomNum)){
					thisapartment=apartmentList.get(i);
					break;
				}	
			}
			apartmentServiceimpl.checkIn(thisapartment);
			System.out.println(thisapartment);
		}
		
		String jsonROOMOfString = (String) session.getAttribute("jsonROOM");
		System.out.println(jsonROOMOfString);
		customerServiceimpl.insert(customer);
		return "Bill";
	}
	
	@RequestMapping(produces="text/plain;charset=UTF-8",value="/CustomerInfoForFront",method = RequestMethod.GET)
	public String CustomerInfoForFront(HttpSession session) throws JsonProcessingException{
		LOG.info("customerInfoForFront...");
		List<Customer> customerList = customerServiceimpl.getAllCustomer();
		List<Customer> customerJSON = new ArrayList<Customer>();
		for (int i = 0; i < customerList.size(); i++){
			Customer customer = new Customer();
			customer.setCustomerId(customerList.get(i).getCustomerId());
			customer.setinTime(customerList.get(i).getinTime());
			customer.setcName(customerList.get(i).getcName());
			customer.setcardID(customerList.get(i).getcardID());
			customer.setcSex(customerList.get(i).getcSex());
			customer.setroomNum(customerList.get(i).getroomNum());
			customerJSON.add(customer);
		}
		ObjectMapper mapper = new ObjectMapper();
		String jsonCustomer = mapper.writeValueAsString(customerJSON);
		session.setAttribute("jsonCustomer", jsonCustomer);
		System.out.println(jsonCustomer);
		return "CustomerInfoForFront";
	}
	
	@RequestMapping(value="/CustomerInfoForAdm",method = RequestMethod.GET)
	public String CustomerInfoForAdm(HttpSession session){
		LOG.info("customerInfoForAdm...");
		return "CustomerInfoForAdm";
	}
	
	@RequestMapping(produces="text/plain;charset=UTF-8",value="/FrontManagement",method = RequestMethod.GET)
	public String FrontManagement(HttpSession session) throws JsonProcessingException{
		LOG.info("FrontManagement...");
		List<Administrator> admList = administratorServiceimpl.getAllAdministrator();
		List<Administrator> admJSON = new ArrayList<Administrator>();
		for (int i = 0; i < admList.size(); i++){
			Administrator administrator = new Administrator();
			administrator.setAdmId(admList.get(i).getAdmId());
			administrator.setaName(admList.get(i).getaName());
			administrator.setaPassword(admList.get(i).getaPassword());
			administrator.setaSex(admList.get(i).getaSex());
			admJSON.add(administrator);
		}
		ObjectMapper mapper = new ObjectMapper();
		String json = mapper.writeValueAsString(admJSON);
		session.setAttribute("json", json);
		System.out.println(json);
//		JSONArray jsonArray = new JSONArray();
//		for (int i = 0; i < admList.size(); i++) {
//			JSONObject jsonObject = new JSONObject();
//			jsonObject.put("AdmId",admList.get(i).getAdmId());
//			jsonObject.put("aName", admList.get(i).getaName());
//			jsonObject.put("aPassword", admList.get(i).getaPassword());
//			jsonObject.put("aSex", admList.get(i).getaSex());
//			jsonArray.add(jsonObject);
//		}
//		ObjectMapper mapper = new ObjectMapper();
//		String json = mapper.writeValueAsString(jsonArray);
//        String jsonString1 = jsonArray.toString();
//        CreateFileUtil.createJsonFile(jsonString1, "src/main/webapp/json", "frontInfo");
		return "FrontManagement";
	}
	
	@RequestMapping(produces="text/plain;charset=UTF-8",value="/ApartmentManagement",method = RequestMethod.GET)
	public String ApartmentManagement(HttpSession session) throws JsonProcessingException{
		LOG.info("ApartmentManagement...");
		List<Apartment> apartmentList = apartmentServiceimpl.getAllApartment();
		List<Apartment> apartmentJSON = new ArrayList<Apartment>();
		for (int i = 0; i < apartmentList.size(); i++){
			Apartment apartment = new Apartment();
			apartment.setroomNum(apartmentList.get(i).getroomNum());
			apartment.setPrice(apartmentList.get(i).getPrice());
			apartment.setState(apartmentList.get(i).getState());
			apartmentJSON.add(apartment);
		}
		ObjectMapper mapperROOM = new ObjectMapper();
		String jsonROOM = mapperROOM.writeValueAsString(apartmentJSON);
		session.setAttribute("jsonROOM", jsonROOM);
		System.out.println(jsonROOM);
		return "ApartmentManagement";
	}
	
	@RequestMapping(produces="text/plain;charset=UTF-8",value="/ApartmentManageAdm",method = RequestMethod.GET)
	public String ApartmentManageAdm(HttpSession session) throws JsonProcessingException{
		LOG.info("ApartmentManageAdm...");
		List<Apartment> apartmentList = apartmentServiceimpl.getAllApartment();
		List<Apartment> apartmentJSON = new ArrayList<Apartment>();
		for (int i = 0; i < apartmentList.size(); i++){
			Apartment apartment = new Apartment();
			apartment.setroomNum(apartmentList.get(i).getroomNum());
			apartment.setPrice(apartmentList.get(i).getPrice());
			apartment.setState(apartmentList.get(i).getState());
			apartmentJSON.add(apartment);
		}
		ObjectMapper mapperROOM = new ObjectMapper();
		String jsonROOM = mapperROOM.writeValueAsString(apartmentJSON);
		session.setAttribute("jsonROOM", jsonROOM);
		System.out.println(jsonROOM);
		return "ApartmentManageAdm";
	}
	
	@RequestMapping(value="/checkOut",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String checkOut(Apartment apartment,HttpServletRequest request,HttpSession session) {
		LOG.info("checkOut...");
		Apartment thisapartment = new Apartment();
		//区别前端界面是‘前台客房管理’还是‘管理员客房管理’
		String flag = request.getParameter("flag");
		System.out.println(flag);
		String roomNum = request.getParameter("roomNum");
		System.out.println(roomNum);
		List<Apartment> apartmentList = apartmentServiceimpl.getAllApartment();
		for (int i = 0; i < apartmentList.size(); i++){
			if(apartmentList.get(i).getroomNum().equals(roomNum)){
				thisapartment=apartmentList.get(i);
				System.out.println(thisapartment);
				break;
			}	
		}
		apartmentServiceimpl.checkOut(thisapartment);
		if(flag.equals("adm"))
			return "ApartmentManageAdm";
		else if(flag.equals("front"))
			return "ApartmentManagement";
		else
			return "";
	}
	
	@RequestMapping(value="/ResetPrice",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String ResetPrice(Apartment apartment,HttpServletRequest request,HttpSession session) {
		LOG.info("ResetPrice...");
		Apartment thisapartment = new Apartment();
		String price = request.getParameter("price");
		int aprice = Integer.parseInt(price);
		System.out.println(price);
		String roomNum = request.getParameter("roomNum");
		System.out.println(roomNum);
		List<Apartment> apartmentList = apartmentServiceimpl.getAllApartment();
		for (int i = 0; i < apartmentList.size(); i++){
			if(apartmentList.get(i).getroomNum().equals(roomNum)){
				thisapartment=apartmentList.get(i);
				System.out.println(thisapartment);
				break;
			}	
		}
		thisapartment.setPrice(aprice);
		apartmentServiceimpl.ResetPrice(thisapartment);
		return "ApartmentManageAdm";
	}

	@RequestMapping("/logout")
	public String logout(HttpSession session) {
		LOG.info("logout...");
		session.invalidate();
		return "login";
	}
	
}
