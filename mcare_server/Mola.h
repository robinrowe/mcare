// Mola.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Mola_h
#define Mola_h

#include <iostream>

class Mola
{	Mola(const Mola&) = delete;
	void operator=(const Mola&) = delete;

public:
	~Mola()
	{}
	Mola()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Mola& mola)
{	return mola.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Mola& mola)
{	return mola.Input(is);
}

#endif
