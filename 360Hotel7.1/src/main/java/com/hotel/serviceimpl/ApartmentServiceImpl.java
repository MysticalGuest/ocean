package com.hotel.serviceimpl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.hotel.dao.ApartmentDao;
import com.hotel.entity.Apartment;
import com.hotel.service.IApartmentService;

@Service // 标记当前类是service
public class ApartmentServiceImpl implements IApartmentService {
	@Autowired
	private ApartmentDao apartmentDao;

	@Override
	public Apartment login(Apartment apartment) {
		return null;
	}

	@Override
	public List<Apartment> getAllApartment() {
		return apartmentDao.getAllApartment();
	}
	
	@Override
	public List<Apartment> getSpareApartment() {
		return apartmentDao.getSpareApartment();
	}

	@Override
	public int insert(Apartment apartment) {
		return apartmentDao.insert(apartment);
	}

	@Override
	public int ResetPrice(Apartment apartment) {
		return apartmentDao.ResetPrice(apartment);
	}
	
	@Override
	public int checkOut(Apartment apartment) {
		return apartmentDao.checkOut(apartment);
	}
	
	@Override
	public int checkIn(Apartment apartment) {
		return apartmentDao.checkIn(apartment);
	}


}
