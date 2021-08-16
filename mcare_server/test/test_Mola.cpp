// test_Mola.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Mola.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Mola" << endl;
	Mola mola;
	if(!mola)
	{	cout << "Mola failed on operator!" << endl;
		return 1;
	}
	cout << mola << endl;
	cout << "Mola Passed!" << endl;
	return 0;
}
