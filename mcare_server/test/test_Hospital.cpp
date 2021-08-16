// test_Hospital.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Hospital.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Hospital" << endl;
	Hospital hospital;
	if(!hospital)
	{	cout << "Hospital failed on operator!" << endl;
		return 1;
	}
	cout << hospital << endl;
	cout << "Hospital Passed!" << endl;
	return 0;
}
