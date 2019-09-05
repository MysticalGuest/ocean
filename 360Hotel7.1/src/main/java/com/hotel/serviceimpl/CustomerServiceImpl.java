package com.hotel.serviceimpl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.hotel.dao.CustomerDao;
import com.hotel.entity.Customer;
import com.hotel.service.ICustomerService;

@Service // 标记当前类是service
public class CustomerServiceImpl implements ICustomerService {
	@Autowired
	private CustomerDao customerDao;

	@Override
	public Customer login(Customer customer) {
		return null;
	}

	@Override
	public List<Customer> getAllCustomer() {
		return customerDao.getAllCustomer();
	}

	@Override
	public int insert(Customer customer) {
		return customerDao.insert(customer);
	}

//	@Override
//	public int removeCustomerById(int userid) {
//		return userDao.removeUserById(userid);
//	}
//
//	@Override
//	public int updateUser_pass(Users user) {
//		return userDao.updateUser_pass(user);
//	}

	@Override
	public Customer getCustomerById(Customer customer) {
		return customerDao.getCustomerById(customer);
	}

}
