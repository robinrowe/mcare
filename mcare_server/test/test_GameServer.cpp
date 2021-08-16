// test_GameServer.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../GameServer.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing GameServer" << endl;
	GameServer gameServer;
	if(!gameServer)
	{	cout << "GameServer failed on operator!" << endl;
		return 1;
	}
	cout << gameServer << endl;
	cout << "GameServer Passed!" << endl;
	return 0;
}
