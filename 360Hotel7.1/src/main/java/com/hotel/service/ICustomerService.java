package com.hotel.service;

import java.util.List;

import com.hotel.entity.Customer;

public interface ICustomerService {

	int insert(Customer customer);

	Customer login(Customer customer);

	List<Customer> getAllCustomer();

	Customer getCustomerById(Customer customer);
}
