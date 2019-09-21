package com.hotel.dao;

import java.util.List;

import org.apache.ibatis.annotations.Insert;
import org.apache.ibatis.annotations.Mapper;
import org.apache.ibatis.annotations.Options;
import org.apache.ibatis.annotations.Select;
import org.apache.ibatis.annotations.Update;

import com.hotel.entity.Expense;

@Mapper // 标记当前类为功能映射文件
public interface ExpenseDao {
	
	@Insert("insert into expense(kinds,price) values (#{kinds},#{price})")
	@Options(useGeneratedKeys = true, keyProperty = "kinds")
	int insert(Expense expense);

	@Select("select * from expense")
	List<Expense> getAllKinds();
	
	@Update("update expense set price=#{price} where kinds=#{kinds}")
	int updatePrice(Expense expense);

}
