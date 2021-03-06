package com.hotel.dao;

import java.util.List;

import org.apache.ibatis.annotations.Insert;
import org.apache.ibatis.annotations.Mapper;
import org.apache.ibatis.annotations.Options;
import org.apache.ibatis.annotations.Select;
import org.apache.ibatis.annotations.Update;

import com.hotel.entity.Administrator;

@Mapper // 标记当前类为功能映射文件
public interface AdministratorDao {
	@Insert("insert into administrator (AdmId,aName,aPassword,aSex,limit) values (#{AdmId},#{aName},#{aPassword},#{aSex},#{limit})")
	@Options(useGeneratedKeys = true, keyProperty = "AdmId")
	int insert(Administrator administrator);

	@Select("select * from administrator where AdmId=#{AdmId} and aPassword=#{aPassword}")
	Administrator login(Administrator administrator);

	@Select("select * from administrator")
	List<Administrator> getAllAdministrator();

	@Update("update administrator set aName=#{aName},aPassword=#{aPassword},aSex=#{aSex} where admId=#{admId}")
	int updateAdm(Administrator adm);

	@Select("select * from administrator where AdmId=#{AdmId}")
	Administrator getAdministratorById(Administrator adm);

}
