// test_Player.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Player.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Player" << endl;
	Player player;
	if(!player)
	{	cout << "Player failed on operator!" << endl;
		return 1;
	}
	cout << player << endl;
	cout << "Player Passed!" << endl;
	return 0;
}
