// GameServer.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef GameServer_h
#define GameServer_h

#include <iostream>

class GameServer
{	GameServer(const GameServer&) = delete;
	void operator=(const GameServer&) = delete;

public:
	~GameServer()
	{}
	GameServer()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const GameServer& gameServer)
{	return gameServer.Print(os);
}


inline
std::istream& operator>>(std::istream& is,GameServer& gameServer)
{	return gameServer.Input(is);
}

#endif
