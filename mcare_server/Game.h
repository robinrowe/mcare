// Game.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Game_h
#define Game_h

#include <iostream>

class Game
{	Game(const Game&) = delete;
	void operator=(const Game&) = delete;

public:
	~Game()
	{}
	Game()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Game& game)
{	return game.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Game& game)
{	return game.Input(is);
}

#endif
