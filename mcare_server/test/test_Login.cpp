// test_Login.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Login.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Login" << endl;
	Login login;
	if(!login)
	{	cout << "Login failed on operator!" << endl;
		return 1;
	}
	cout << login << endl;
	cout << "Login Passed!" << endl;
	return 0;
}
