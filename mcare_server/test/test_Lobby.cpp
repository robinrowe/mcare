// test_Lobby.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Lobby.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Lobby" << endl;
	Lobby lobby;
	if(!lobby)
	{	cout << "Lobby failed on operator!" << endl;
		return 1;
	}
	cout << lobby << endl;
	cout << "Lobby Passed!" << endl;
	return 0;
}
