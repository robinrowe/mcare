// test_Hospitals.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Hospitals.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Hospitals" << endl;
	Hospitals hospitals;
	if(!hospitals)
	{	cout << "Hospitals failed on operator!" << endl;
		return 1;
	}
	cout << hospitals << endl;
	cout << "Hospitals Passed!" << endl;
	return 0;
}
