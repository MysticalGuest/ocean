package com.hotel.service;

import java.util.List;

import com.hotel.entity.Customer;

public interface ICustomerService {

	int insert(Customer customer);

	Customer login(Customer customer);

	List<Customer> getAllCustomer();
	
	List<Customer> doSearch(Customer customer);
	
	int removeCustomerById(Customer CustomerId);

//	int updateUser_pass(Users user);

	Customer getCustomerById(Customer customer);
}
