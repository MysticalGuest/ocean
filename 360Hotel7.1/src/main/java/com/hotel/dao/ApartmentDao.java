package com.hotel.dao;

import java.util.List;

import org.apache.ibatis.annotations.Delete;
import org.apache.ibatis.annotations.Insert;
import org.apache.ibatis.annotations.Mapper;
import org.apache.ibatis.annotations.Options;
import org.apache.ibatis.annotations.Select;
import org.apache.ibatis.annotations.Update;

import com.hotel.entity.Apartment;

@Mapper // 标记当前类为功能映射文件
public interface ApartmentDao {
	@Insert("insert into apartment (roomNum,price) values (#{roomNum},#{price})")
	@Options(useGeneratedKeys = true, keyProperty = "roomNum")
	int insert(Apartment apartment);

	@Select("select * from apartment where roomNum=#{roomNum}")
	Apartment login(Apartment apartment);

	@Select("select * from apartment")
	List<Apartment> getAllApartment();
	
	@Select("select * from apartment where state=false")
	List<Apartment> getSpareApartment();

//	@Delete("delete from customers where CustomerId=#{CustomerId}")
//	int removeUserById(String CustomerId);
//
	@Update("update apartment set price=#{price} where roomNum=#{roomNum}")
	int ResetPrice(Apartment apartment);
	
	@Update("update apartment set state=false where roomNum=#{roomNum}")
	int checkOut(Apartment apartment);
	
	@Update("update apartment set state=true where roomNum=#{roomNum}")
	int checkIn(Apartment apartment);

//	@Select("select * from apartment where id=#{id}")
//	Apartment getApartmentById(Apartment apartment);

}

