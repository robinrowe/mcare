// Action.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Action_h
#define Action_h

#include <iostream>

class Action
{	Action(const Action&) = delete;
	void operator=(const Action&) = delete;

public:
	~Action()
	{}
	Action()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Action& action)
{	return action.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Action& action)
{	return action.Input(is);
}

#endif
