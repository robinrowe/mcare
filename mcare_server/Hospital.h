// Hospital.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Hospital_h
#define Hospital_h

#include <iostream>

class Hospital
{	Hospital(const Hospital&) = delete;
	void operator=(const Hospital&) = delete;

public:
	~Hospital()
	{}
	Hospital()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Hospital& hospital)
{	return hospital.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Hospital& hospital)
{	return hospital.Input(is);
}

#endif
