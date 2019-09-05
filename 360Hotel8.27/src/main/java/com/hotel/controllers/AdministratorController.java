package com.hotel.controllers;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;

import com.hotel.entity.Administrator;
import com.hotel.entity.Apartment;
import com.hotel.entity.Customer;
import com.alibaba.fastjson.JSONObject;
import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
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
		return "hello";
	}
	
	@RequestMapping(value="/Home",produces="text/plain;charset=UTF-8",method = RequestMethod.GET)
	public String Home(HttpSession session) throws JsonProcessingException{
		LOG.info("home...");
		return "Home";
	}
	
	@RequestMapping(value="/HomeForAdm",produces="text/plain;charset=UTF-8",method = RequestMethod.GET)
	public String HomeForAdm(HttpSession session) throws JsonProcessingException{
		LOG.info("homeForAdm...");
		return "HomeForAdm";
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
	
	@RequestMapping(value="/CustomerInfoForFront",method = RequestMethod.GET)
	public String CustomerInfoForFront(HttpServletRequest request,HttpSession session) throws JsonProcessingException, ParseException{
		LOG.info("customerInfoForFront...");
		List<Customer> customerList = customerServiceimpl.getAllCustomer();
		List<Customer> customerJSON = new ArrayList<Customer>();
		for (int i = 0; i < customerList.size(); i++){
			Customer Customer = new Customer();
			Customer.setCustomerId(customerList.get(i).getCustomerId());
			//解决时间.0问题
			SimpleDateFormat myFmt=new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			Date date = myFmt.parse(customerList.get(i).getinTime().toString());
			String inDate = myFmt.format(date);
			Customer.setinTime(inDate);
			
			Customer.setcName(customerList.get(i).getcName());
			Customer.setcardID(customerList.get(i).getcardID());
			Customer.setcSex(customerList.get(i).getcSex());
			Customer.setroomNum(customerList.get(i).getroomNum());
			customerJSON.add(Customer);
		}
		ObjectMapper mapper = new ObjectMapper();
		String jsonCustomer = mapper.writeValueAsString(customerJSON);
		session.setAttribute("jsonCustomer", jsonCustomer);
		System.out.println(jsonCustomer);
		return "CustomerInfoForFront";
	}
	
	@RequestMapping(value="/CustomerInfoForFront",method = RequestMethod.POST)
	public String CustomerInfoForFrontPOST(HttpServletRequest request,HttpSession session) throws JsonProcessingException, ParseException{
		LOG.info("customerInfoForFrontPOST...");
		Customer customer = new Customer();
		String inTime = request.getParameter("datetime");
		System.out.println("inTime:"+inTime);
		customer.setinTime(inTime);
		String cName = request.getParameter("cName");
		System.out.println("cName:"+cName);
		customer.setcName(cName);
		String roomNum = request.getParameter("roomNum");
		System.out.println("roomNum:"+roomNum);
		customer.setroomNum(roomNum);
		List<Customer> customerList = customerServiceimpl.doSearch(customer);
		List<Customer> customerJSON = new ArrayList<Customer>();
		for (int i = 0; i < customerList.size(); i++){
			Customer oneCustomer = new Customer();
			oneCustomer.setCustomerId(customerList.get(i).getCustomerId());
			//解决时间.0问题
			SimpleDateFormat myFmt=new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			Date date = myFmt.parse(customerList.get(i).getinTime().toString());
			String endDate = myFmt.format(date);
			oneCustomer.setinTime(endDate);
			
			oneCustomer.setcName(customerList.get(i).getcName());
			oneCustomer.setcardID(customerList.get(i).getcardID());
			oneCustomer.setcSex(customerList.get(i).getcSex());
			oneCustomer.setroomNum(customerList.get(i).getroomNum());
			customerJSON.add(oneCustomer);
		}
		ObjectMapper mapper = new ObjectMapper();
		String jsonCustomer = mapper.writeValueAsString(customerJSON);
		session.setAttribute("jsonCustomer", jsonCustomer);
		System.out.println(jsonCustomer);
		return "CustomerInfoForFront";
	}
	
	@RequestMapping(value="/CustomerInfoForAdm",method = RequestMethod.GET)
	public String CustomerInfoForAdm(HttpSession session) throws JsonProcessingException, ParseException{
		LOG.info("customerInfoForAdm...");
		List<Customer> customerList = customerServiceimpl.getAllCustomer();
		List<Customer> customerJSON = new ArrayList<Customer>();
		for (int i = 0; i < customerList.size(); i++){
			Customer customer = new Customer();
			customer.setCustomerId(customerList.get(i).getCustomerId());
			//解决时间.0问题
			SimpleDateFormat myFmt=new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			Date date = myFmt.parse(customerList.get(i).getinTime().toString());
			String endDate = myFmt.format(date);
			customer.setinTime(endDate);
			
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
		return "CustomerInfoForAdm";
	}
	
	@RequestMapping(value="/CustomerInfoForAdm",method = RequestMethod.POST)
	public String CustomerInfoForAdmPOST(HttpServletRequest request,HttpSession session) throws JsonProcessingException, ParseException{
		LOG.info("customerInfoForAdmPOST...");
		Customer customer = new Customer();
		String inTime = request.getParameter("datetime");
		System.out.println("inTime:"+inTime);
		customer.setinTime(inTime);
		String cName = request.getParameter("cName");
		System.out.println("cName:"+cName);
		customer.setcName(cName);
		String roomNum = request.getParameter("roomNum");
		System.out.println("roomNum:"+roomNum);
		customer.setroomNum(roomNum);
		List<Customer> customerList = customerServiceimpl.doSearch(customer);
		List<Customer> customerJSON = new ArrayList<Customer>();
		for (int i = 0; i < customerList.size(); i++){
			Customer oneCustomer = new Customer();
			oneCustomer.setCustomerId(customerList.get(i).getCustomerId());
			//解决时间.0问题
			SimpleDateFormat myFmt=new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			Date date = myFmt.parse(customerList.get(i).getinTime().toString());
			String endDate = myFmt.format(date);
			oneCustomer.setinTime(endDate);
			
			oneCustomer.setcName(customerList.get(i).getcName());
			oneCustomer.setcardID(customerList.get(i).getcardID());
			oneCustomer.setcSex(customerList.get(i).getcSex());
			oneCustomer.setroomNum(customerList.get(i).getroomNum());
			customerJSON.add(oneCustomer);
		}
		ObjectMapper mapper = new ObjectMapper();
		String jsonCustomer = mapper.writeValueAsString(customerJSON);
		session.setAttribute("jsonCustomer", jsonCustomer);
		System.out.println(jsonCustomer);
		return "CustomerInfoForAdm";
	}
	
	@RequestMapping(value="/deleteChecked",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String deleteChecked(HttpServletRequest request,HttpSession session) {
		LOG.info("deleteChecked...");
		String strCustomerId = request.getParameter("strCustomerId");
		System.out.println(strCustomerId);
		String[] customerIdArray = strCustomerId.split(","); // 用,分割
		for(String customerId:customerIdArray){
			System.out.println(customerId);
			LOG.info("Delete...");
			Customer customer = new Customer();
			customer.setCustomerId(customerId);;
			customerServiceimpl.removeCustomerById(customer);
		}
		return "CustomerInfoForAdm";
	}
	
	@RequestMapping(value="/FrontManagement",method = RequestMethod.GET,produces="text/plain;charset=UTF-8")
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
		return "FrontManagement";
	}
	
	@RequestMapping(value="/ApartmentManagement",method = RequestMethod.GET,produces="text/plain;charset=UTF-8")
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
		
		//房价搜索框
		List<Apartment> priceList = apartmentServiceimpl.getPrice();
		List<JSONObject> priceJSON = new ArrayList<JSONObject>();
		
		for (int i = 0; i < priceList.size(); i++){
			JSONObject aPrice=new JSONObject();
			aPrice.put("price",priceList.get(i).getPrice());
			aPrice.put("num",i+1);
			priceJSON.add(aPrice);
		}
		ObjectMapper mapperPrice = new ObjectMapper();
		String jsonPrice = mapperPrice.writeValueAsString(priceJSON);
		session.setAttribute("jsonPrice", jsonPrice);
		System.out.println("Price"+jsonPrice);
		
		return "ApartmentManagement";
	}
	
	@RequestMapping(value="/ApartmentManagement",method = RequestMethod.POST,produces="text/plain;charset=UTF-8")
	public String ApartmentManagementPOST(HttpServletRequest request,HttpSession session) throws JsonProcessingException{
		LOG.info("ApartmentManagementPOST...");
		Apartment apartment = new Apartment();
		String isShowAll = request.getParameter("isShowAll");
		System.out.println("isShowAll:"+isShowAll);
		String roomNum;
		if(isShowAll.equals("Yes")){
			roomNum = "";
		}
		else{
			roomNum = request.getParameter("roomNum");
			System.out.println("roomNum:"+roomNum);
		}
		apartment.setroomNum(roomNum);
		//getParameter("")方法返回值为String类型
		String price = request.getParameter("forPrice");
		System.out.println("priceStr:"+price);
		if(!price.equals("")){
			int aprice = Integer.parseInt(price);
			System.out.println("price:"+price);
			apartment.setPrice(aprice);
		}
		String state = request.getParameter("forState");
		if(state.equals("false")||state.equals("true")){
			boolean booleanState = Boolean.parseBoolean(state); 
			System.out.println("state:"+booleanState);
			apartment.setState(booleanState);
		}
		System.out.println("stateStr:"+state);
		List<Apartment> apartmentList;
		if(!roomNum.equals("")&&!price.equals("")&&!state.equals("")){
			apartmentList = apartmentServiceimpl.searchApartment(apartment);
		}
		else if(roomNum.equals("")&&!price.equals("")&&!state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByPriceAndState(apartment);
		}
		else if(!roomNum.equals("")&&price.equals("")&&!state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByRoomAndState(apartment);
		}
		else if(!roomNum.equals("")&&!price.equals("")&&state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByRoomAndState(apartment);
		}
		else if(!roomNum.equals("")&&price.equals("")&&state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByRoomNum(apartment);
		}
		else if(roomNum.equals("")&&!price.equals("")&&state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByPrice(apartment);
		}
		else if(roomNum.equals("")&&price.equals("")&&!state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByState(apartment);
		}
		else{
			apartmentList = apartmentServiceimpl.getAllApartment();
		}
		List<Apartment> apartmentJSON = new ArrayList<Apartment>();
		for (int i = 0; i < apartmentList.size(); i++){
			Apartment oneApartment = new Apartment();
			oneApartment.setroomNum(apartmentList.get(i).getroomNum());
			oneApartment.setPrice(apartmentList.get(i).getPrice());
			oneApartment.setState(apartmentList.get(i).getState());
			apartmentJSON.add(oneApartment);
		}
		ObjectMapper mapperROOM = new ObjectMapper();
		String jsonROOM = mapperROOM.writeValueAsString(apartmentJSON);
		session.setAttribute("jsonROOM", jsonROOM);
		System.out.println(jsonROOM);
		return "ApartmentManagement";
	}
	
	@RequestMapping(value="/ApartmentManageAdm",method = RequestMethod.GET,produces="text/plain;charset=UTF-8")
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
		
		//房价搜索框
		List<Apartment> priceList = apartmentServiceimpl.getPrice();
		List<JSONObject> priceJSON = new ArrayList<JSONObject>();
		
		for (int i = 0; i < priceList.size(); i++){
			JSONObject aPrice=new JSONObject();
			aPrice.put("price",priceList.get(i).getPrice());
			aPrice.put("num",i+1);
			priceJSON.add(aPrice);
		}
		ObjectMapper mapperPrice = new ObjectMapper();
		String jsonPrice = mapperPrice.writeValueAsString(priceJSON);
		session.setAttribute("jsonPrice", jsonPrice);
		System.out.println("Price"+jsonPrice);
		return "ApartmentManageAdm";
	}
	
	@RequestMapping(value="/ApartmentManageAdm",method = RequestMethod.POST,produces="text/plain;charset=UTF-8")
	public String ApartmentManageAdmPOST(HttpSession session) throws JsonProcessingException{
		LOG.info("ApartmentManageAdmPOST...");
		return "ApartmentManageAdm";
	}
	
	@RequestMapping(value="/ApartmentSearch",method = RequestMethod.POST,produces="text/plain;charset=UTF-8")
	public String ApartmentSearch(HttpServletRequest request,HttpSession session) throws JsonProcessingException{
		LOG.info("ApartmentSearch...");
		Apartment apartment = new Apartment();
		String roomNum;
		roomNum = request.getParameter("roomNum");
		System.out.println("roomNum:"+roomNum);
		apartment.setroomNum(roomNum);
		//getParameter("")方法返回值为String类型
		String price = request.getParameter("selectPrice");
		System.out.println("priceStr:"+price);
		if(!price.equals("")){
			int aprice = Integer.parseInt(price);
			System.out.println("price:"+price);
			apartment.setPrice(aprice);
		}
		String state = request.getParameter("state");
		if(state.equals("false")||state.equals("true")){
			boolean booleanState = Boolean.parseBoolean(state); 
			System.out.println("state:"+booleanState);
			apartment.setState(booleanState);
		}
		System.out.println("stateStr:"+state);
		List<Apartment> apartmentList;
		if(!roomNum.equals("")&&!price.equals("")&&!state.equals("")){
			apartmentList = apartmentServiceimpl.searchApartment(apartment);
		}
		else if(roomNum.equals("")&&!price.equals("")&&!state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByPriceAndState(apartment);
		}
		else if(!roomNum.equals("")&&price.equals("")&&!state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByRoomAndState(apartment);
		}
		else if(!roomNum.equals("")&&!price.equals("")&&state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByRoomAndState(apartment);
		}
		else if(!roomNum.equals("")&&price.equals("")&&state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByRoomNum(apartment);
		}
		else if(roomNum.equals("")&&!price.equals("")&&state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByPrice(apartment);
		}
		else if(roomNum.equals("")&&price.equals("")&&!state.equals("")){
			apartmentList = apartmentServiceimpl.getApartmentByState(apartment);
		}
		else{
			apartmentList = apartmentServiceimpl.getAllApartment();
		}
		List<Apartment> apartmentJSON = new ArrayList<Apartment>();
		for (int i = 0; i < apartmentList.size(); i++){
			Apartment oneApartment = new Apartment();
			oneApartment.setroomNum(apartmentList.get(i).getroomNum());
			oneApartment.setPrice(apartmentList.get(i).getPrice());
			oneApartment.setState(apartmentList.get(i).getState());
			apartmentJSON.add(oneApartment);
		}
		ObjectMapper mapperROOM = new ObjectMapper();
		String jsonROOM = mapperROOM.writeValueAsString(apartmentJSON);
		session.setAttribute("jsonROOM", jsonROOM);
		System.out.println(jsonROOM);
		return "ApartmentManageAdm";
	}
	
	@RequestMapping(value="/resetPriceChecked",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String resetPriceChecked(HttpServletRequest request,HttpSession session) {
		LOG.info("resetPriceChecked...");
		String strRoom = request.getParameter("strRoom");
		System.out.println(strRoom);
		String price = request.getParameter("price");
		int aprice = Integer.parseInt(price);
		System.out.println(price);
		String[] roomArray = strRoom.split(","); // 用,分割
		for(String roomNum:roomArray){
			System.out.println(roomNum);
			LOG.info("resetPriceChecked...");
			Apartment tempApartment = new Apartment();
			tempApartment.setroomNum(roomNum);
			tempApartment.setPrice(aprice);
			apartmentServiceimpl.ResetPrice(tempApartment);
		}
		return "ApartmentManageAdm";
	}
	
	@RequestMapping(value="/checkOut",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String checkOut(HttpServletRequest request,HttpSession session) {
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
	
	@RequestMapping(value="/allCheckOut",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String allCheckOut(HttpServletRequest request,HttpSession session) {
		LOG.info("allCheckOut...");
		//区别前端界面是‘前台客房管理’还是‘管理员客房管理’
		String flag = request.getParameter("flag");
		System.out.println(flag);
		apartmentServiceimpl.allCheckOut();
		if(flag.equals("adm"))
			return "ApartmentManageAdm";
		else if(flag.equals("front"))
			return "ApartmentManagement";
		else
			return "";
	}
	
	@RequestMapping(value="/checkOutChecked",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String checkOutChecked(HttpServletRequest request,HttpSession session) {
		LOG.info("checkOutChecked...");
		//区别前端界面是‘前台客房管理’还是‘管理员客房管理’
		String flag = request.getParameter("flag");
		System.out.println(flag);
		String strRoom = request.getParameter("strRoom");
		System.out.println(strRoom);
		String[] roomArray = strRoom.split(","); // 用,分割
		for(String roomNum:roomArray){
			System.out.println(roomNum);
			LOG.info("CheckOut...");
			Apartment tempApartment = new Apartment();
			tempApartment.setroomNum(roomNum);
			apartmentServiceimpl.checkOut(tempApartment);
		}
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
	
	@RequestMapping(value="/ResetAdmInfo",method = RequestMethod.POST,produces = "text/plain;charset=UTF-8")
	public String ResetAdmInfo(Administrator administrator,HttpServletRequest request,HttpSession session) {
		LOG.info("ResetAdmInfo...");
		Administrator thisadministrator = new Administrator();
		String admId = request.getParameter("admId");
		System.out.println(admId);
		String aName = request.getParameter("aName");
		System.out.println(aName);
		String aPassword = request.getParameter("aPassword");
		String aSex = request.getParameter("aSex");
		if(aSex.equals("man"))
			aSex="男";
		else if(aSex.equals("woman"))
			aSex="女";
		List<Administrator> administratorList = administratorServiceimpl.getAllAdministrator();
		for (int i = 0; i < administratorList.size(); i++){
			if(administratorList.get(i).getAdmId().equals(admId)){
				thisadministrator=administratorList.get(i);
				System.out.println(thisadministrator);
				break;
			}	
		}
		thisadministrator.setaName(aName);
		thisadministrator.setaPassword(aPassword);
		thisadministrator.setaSex(aSex);
		administratorServiceimpl.updateAdm(thisadministrator);
		return "FrontManagement";
	}

	@RequestMapping("/logout")
	public String logout(HttpSession session) {
		LOG.info("logout...");
		session.invalidate();
		return "login";
	}
	
}
