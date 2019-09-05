package com.hotel.entity;

import java.io.Serializable;

import javax.persistence.Entity;

@Entity
public class Customer implements Serializable {
	private static final long serialVersionUID = 1L;
	private String CustomerId;
	private String inTime;
	private String cName;
	private String cardID;
	private String cSex;
	private String roomNum;

//	public Integer getAdmId() {
//		return Integer.parseInt(AdmId);
//	}
	public String getCustomerId() {
		return CustomerId;
	}

	public void setCustomerId(String CustomerId) {
		this.CustomerId = CustomerId;
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

	@Override
	public String toString() {
		return "Customers [CustomerId="+CustomerId +",inTime="+inTime+",cName="+cName+",cardID="+cardID+ ",cSex="+cSex + ",roomNum="+roomNum+"]";
	}

	public Customer() {
		super();
		// TODO Auto-generated constructor stub
	}

	public Customer(String CustomerId, String inTime,String cName, String cardID, String cSex, String roomNum) {
		super();
		this.CustomerId = CustomerId;
		this.inTime = inTime;
		this.cName = cName;
		this.cardID = cardID;
		this.cSex = cSex;
		this.roomNum = roomNum;
	}

}
