// Lobby.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Lobby_h
#define Lobby_h

#include <iostream>

class Lobby
{	Lobby(const Lobby&) = delete;
	void operator=(const Lobby&) = delete;

public:
	~Lobby()
	{}
	Lobby()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Lobby& lobby)
{	return lobby.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Lobby& lobby)
{	return lobby.Input(is);
}

#endif
