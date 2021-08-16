// test_Action.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Action.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Action" << endl;
	Action action;
	if(!action)
	{	cout << "Action failed on operator!" << endl;
		return 1;
	}
	cout << action << endl;
	cout << "Action Passed!" << endl;
	return 0;
}
