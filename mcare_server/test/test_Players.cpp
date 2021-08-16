// test_Players.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Players.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Players" << endl;
	Players players;
	if(!players)
	{	cout << "Players failed on operator!" << endl;
		return 1;
	}
	cout << players << endl;
	cout << "Players Passed!" << endl;
	return 0;
}
