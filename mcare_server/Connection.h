// Connection.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Connection_h
#define Connection_h

#include <iostream>

class Connection
{	Connection(const Connection&) = delete;
	void operator=(const Connection&) = delete;

public:
	~Connection()
	{}
	Connection()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Connection& connection)
{	return connection.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Connection& connection)
{	return connection.Input(is);
}

#endif
