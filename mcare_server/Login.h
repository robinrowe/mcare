// Login.h 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#ifndef Login_h
#define Login_h

#include <iostream>

class Login
{	Login(const Login&) = delete;
	void operator=(const Login&) = delete;

public:
	~Login()
	{}
	Login()
	{}
	bool operator!() const
	{	// to-do
		return true;
	}
	std::ostream& Print(std::ostream& os) const;
	std::istream& Input(std::istream& is);
};

inline
std::ostream& operator<<(std::ostream& os,const Login& login)
{	return login.Print(os);
}


inline
std::istream& operator>>(std::istream& is,Login& login)
{	return login.Input(is);
}

#endif
