package com.hotel.service;

import java.util.List;

import com.hotel.entity.Apartment;

public interface IApartmentService {
	
	int insert(Apartment apartment);

	Apartment login(Apartment apartment);

	List<Apartment> getAllApartment();
	
	List<Apartment> getSpareApartment();

	int ResetPrice(Apartment apartment);
	
	int checkOut(Apartment apartment);
	
	int checkIn(Apartment apartment);


}
