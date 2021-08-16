// test_Replay.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Replay.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Replay" << endl;
	Replay replay;
	if(!replay)
	{	cout << "Replay failed on operator!" << endl;
		return 1;
	}
	cout << replay << endl;
	cout << "Replay Passed!" << endl;
	return 0;
}
