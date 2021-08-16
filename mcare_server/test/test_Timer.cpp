// test_Timer.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Timer.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Timer" << endl;
	Timer timer;
	if(!timer)
	{	cout << "Timer failed on operator!" << endl;
		return 1;
	}
	cout << timer << endl;
	cout << "Timer Passed!" << endl;
	return 0;
}
