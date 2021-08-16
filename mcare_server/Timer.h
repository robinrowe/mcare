// Timer.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Timer_h
#define Timer_h

#include <iostream>

class Timer
{	Timer(const Timer&) = delete;
	void operator=(const Timer&) = delete;

public:
	~Timer()
	{}
	Timer()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Timer& timer)
{	return timer.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Timer& timer)
{	return timer.Input(is);
}

#endif
