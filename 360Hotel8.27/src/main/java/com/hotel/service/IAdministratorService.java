package com.hotel.service;

import java.util.List;

import com.hotel.entity.Administrator;

public interface IAdministratorService {

	int insert(Administrator administrator);

	Administrator login(Administrator administrator);

	List<Administrator> getAllAdministrator();

//	int removeUserById(int userid);
//
	int updateAdm(Administrator administrator);

	Administrator getAdministratorById(Administrator administrator);
}
