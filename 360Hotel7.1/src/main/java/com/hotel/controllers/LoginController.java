package com.hotel.controllers;

import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.apache.ibatis.annotations.Param;
import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;

import com.hotel.entity.Administrator;
import com.github.pagehelper.PageHelper;
import com.github.pagehelper.PageInfo;
import com.hotel.controllers.AdministratorController;
import com.hotel.serviceimpl.AdministratorServiceImpl;

@Controller
@RequestMapping("")
public class LoginController {
	private static final Logger LOG = Logger.getLogger(AdministratorController.class);
	@Autowired
	private AdministratorServiceImpl administratorService;
	
//	@RequestMapping("/index")
//	public String index() {
//		return "login";
//	}
	
	@RequestMapping(value="/login",method = RequestMethod.POST)
//	@ResponseBody
	public String login(Administrator administrator,@Param("limits") String limits, HttpServletRequest req, HttpSession session) {
		Administrator thisadministrator = administratorService.login(administrator);
		session.setAttribute("thisadministrator", thisadministrator);
		if (thisadministrator != null) {
			System.out.println("登录界面");
			if(thisadministrator.getlimit().equals(limits)&&limits.equals("front")){
				System.out.println(limits);
				System.out.println("前台界面");
				return "redirect:/administrator/CustomerInfoForFront";
			}
			else if(thisadministrator.getlimit().equals(limits)&&limits.equals("administrator")){
				System.out.println("管理员界面");
				return "redirect:/administrator/FrontManagement";
			}
			else{
				return "redirect:login";
			}
			
		}
		else{
			return "redirect:login";
		}
	}
	
	//登录
	@RequestMapping(value = "/login", method = RequestMethod.GET)
	public String login() {
		LOG.info("login...");
		return "login";
	}
	
	//前台登入
	@RequestMapping(value = "/Bill", method = RequestMethod.GET)
	public String front_login() {
		LOG.info("front login...");
		return "Bill";
	}
	
	//管理员登入
	@RequestMapping(value = "/FrontManagement", method = RequestMethod.GET)
	public String adm_login() {
		LOG.info("administrator login...");
		return "FrontManagement";
	}

	@RequestMapping("/logout")
	public String logout(HttpSession session) {
		session.invalidate();
		return "login";
	}
	
}
