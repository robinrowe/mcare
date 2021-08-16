// Player.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Player_h
#define Player_h

#include <iostream>

class Player
{	Player(const Player&) = delete;
	void operator=(const Player&) = delete;

public:
	~Player()
	{}
	Player()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Player& player)
{	return player.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Player& player)
{	return player.Input(is);
}

#endif
