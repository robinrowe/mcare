// Replay.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Replay_h
#define Replay_h

#include <iostream>

class Replay
{	Replay(const Replay&) = delete;
	void operator=(const Replay&) = delete;

public:
	~Replay()
	{}
	Replay()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Replay& replay)
{	return replay.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Replay& replay)
{	return replay.Input(is);
}

#endif
