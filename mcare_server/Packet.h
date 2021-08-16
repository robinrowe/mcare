// Packet.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Packet_h
#define Packet_h

#include <iostream>

class Packet
{	Packet(const Packet&) = delete;
	void operator=(const Packet&) = delete;

public:
	~Packet()
	{}
	Packet()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Packet& packet)
{	return packet.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Packet& packet)
{	return packet.Input(is);
}

#endif
