// Players.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Players_h
#define Players_h

#include <iostream>

class Players
{	Players(const Players&) = delete;
	void operator=(const Players&) = delete;

public:
	~Players()
	{}
	Players()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Players& players)
{	return players.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Players& players)
{	return players.Input(is);
}

#endif
