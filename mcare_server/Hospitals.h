// Hospitals.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Hospitals_h
#define Hospitals_h

#include <iostream>

class Hospitals
{	Hospitals(const Hospitals&) = delete;
	void operator=(const Hospitals&) = delete;

public:
	~Hospitals()
	{}
	Hospitals()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Hospitals& hospitals)
{	return hospitals.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Hospitals& hospitals)
{	return hospitals.Input(is);
}

#endif
