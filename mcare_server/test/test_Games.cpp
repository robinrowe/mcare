// test_Games.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Games.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Games" << endl;
	Games games;
	if(!games)
	{	cout << "Games failed on operator!" << endl;
		return 1;
	}
	cout << games << endl;
	cout << "Games Passed!" << endl;
	return 0;
}
