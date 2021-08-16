// MsgQueue.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef MsgQueue_h
#define MsgQueue_h

#include <iostream>

class MsgQueue
{	MsgQueue(const MsgQueue&) = delete;
	void operator=(const MsgQueue&) = delete;

public:
	~MsgQueue()
	{}
	MsgQueue()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const MsgQueue& msgQueue)
{	return msgQueue.Print(os);
}


inline
std::istream& operator>>(std::istream& is,MsgQueue& msgQueue)
{	return msgQueue.Input(is);
}

#endif
