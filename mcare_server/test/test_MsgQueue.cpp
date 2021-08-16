// test_MsgQueue.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../MsgQueue.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing MsgQueue" << endl;
	MsgQueue msgQueue;
	if(!msgQueue)
	{	cout << "MsgQueue failed on operator!" << endl;
		return 1;
	}
	cout << msgQueue << endl;
	cout << "MsgQueue Passed!" << endl;
	return 0;
}
