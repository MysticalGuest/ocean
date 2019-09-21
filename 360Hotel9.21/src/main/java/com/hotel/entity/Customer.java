 package com.hotel.entity;

import java.io.Serializable;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

import javax.persistence.Entity;

@Entity
public class Customer implements Serializable {
	private static final long serialVersionUID = 1L;
	private String inTime;
	private String cName;
	private String cardID;
	private String cSex;
	private String roomNum;
	private int chargeAndDeposit;
	
	public Customer() {
		super();
		// TODO Auto-generated constructor stub
	}

	public Customer(String inTime,String cName, String cardID, String cSex, String roomNum,int chargeAndDeposit) {
		super();
		this.inTime = inTime;
		this.cName = cName;
		this.cardID = cardID;
		this.cSex = cSex;
		this.roomNum = roomNum;
		this.chargeAndDeposit=chargeAndDeposit;
	}

	public String getinTime() {
		return inTime;
	}

	public void setinTime(String inTime) {
		this.inTime = inTime;
	}

	public String getcName() {
		return cName;
	}

	public void setcName(String cName) {
		this.cName = cName;
	}

	public String getcardID() {
		return cardID;
	}

	public void setcardID(String cardID) {
		this.cardID = cardID;
	}

	public String getcSex() {
		return cSex;
	}

	public void setcSex(String cSex) {
		this.cSex = cSex;
	}
	
	public String getroomNum() {
		return roomNum;
	}

	public void setroomNum(String roomNum) {
		this.roomNum = roomNum;
	}
	
	public int getChargeAndDeposit() {
		return chargeAndDeposit;
	}

	public void setChargeAndDeposit(int chargeAndDeposit) {
		this.chargeAndDeposit = chargeAndDeposit;
	}

//	@Override
//	public String toString() {
//		return "Customers [inTime="+inTime+",cName="+cName+",cardID="+cardID+","
//				+ "cSex="+cSex+",roomNum="+roomNum+",chargeAndDeposit="+chargeAndDeposit+"]";
//	}
	
	//我重写了toString()方法,为了将从数据库拿出的数据直接格式化为JSON格式,可以直接传到前台
	@Override
	public String toString() {
		//解决时间.0问题
		SimpleDateFormat myFmt=new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		Date date = null;
		try {
			date = myFmt.parse(inTime);
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		String inDate = myFmt.format(date);
		
		//如果cardID里带有英文,比如最后一位为x,直接传到前台会出错,现将其处理一下
		if(cardID!=null&&((cardID.charAt(cardID.length()-1)=='x')||(cardID.charAt(cardID.length()-1)=='X')))
			cardID="\""+cardID+"\"";
		
		return "{\"inTime\":\""+inDate+"\",\"cName\":\""+cName+
				"\",\"cardID\":"+cardID+","+ "\"cSex\":"+cSex+",\"roomNum\":\""+
				roomNum+"\",\"chargeAndDeposit\":\""+chargeAndDeposit+"\"}";
	}

}
