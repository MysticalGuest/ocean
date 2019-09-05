package com.hotel.dao;

import java.util.List;

import org.apache.ibatis.annotations.Delete;
import org.apache.ibatis.annotations.Insert;
import org.apache.ibatis.annotations.Mapper;
import org.apache.ibatis.annotations.Options;
import org.apache.ibatis.annotations.Select;
import org.apache.ibatis.annotations.Update;

import com.hotel.entity.Customer;

@Mapper // 标记当前类为功能映射文件
public interface CustomerDao {
	@Insert("insert into customer (inTime,cName,roomNum) values (CURRENT_TIMESTAMP,#{cName},#{roomNum})")
	@Options(useGeneratedKeys = true, keyProperty = "CustomerId")
	int insert(Customer customer);

//	@Select("select * from customer where Customer=#{AdmId} and aPassword=#{aPassword}")
//	Customer login(Customer customer);

	@Select("select * from customer order by inTime desc")
	List<Customer> getAllCustomer();

//	@Delete("delete from customers where CustomerId=#{CustomerId}")
//	int removeUserById(String CustomerId);
//
//	@Update("update customers set cPassword=#{cPassword} where CustomerId=#{CustomerId}")
//	int updateUser_pass(Customer user);

	@Select("select * from customer where CustomerId=#{CustomerId}")
	Customer getCustomerById(Customer customer);

}

