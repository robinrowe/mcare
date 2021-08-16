// Games.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Games_h
#define Games_h

#include <iostream>

class Games
{	Games(const Games&) = delete;
	void operator=(const Games&) = delete;

public:
	~Games()
	{}
	Games()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Games& games)
{	return games.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Games& games)
{	return games.Input(is);
}

#endif
