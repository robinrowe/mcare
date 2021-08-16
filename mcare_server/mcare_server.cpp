// mcare_server.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
using namespace std;

void Usage()
{	cout << "Usage: mcare_server " << endl;
}

enum
{	ok,
	invalid_args

};

int main(int argc,char* argv[])
{	cout << "mcare_server starting..." << endl;
	if(argc < 1)
	{	Usage();
		return invalid_args;
	}

	cout << "mcare_server done!" << endl;
	return ok;
}
