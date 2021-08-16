// test_Connection.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Connection.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Connection" << endl;
	Connection connection;
	if(!connection)
	{	cout << "Connection failed on operator!" << endl;
		return 1;
	}
	cout << connection << endl;
	cout << "Connection Passed!" << endl;
	return 0;
}
