// test_Game.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Game.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Game" << endl;
	Game game;
	if(!game)
	{	cout << "Game failed on operator!" << endl;
		return 1;
	}
	cout << game << endl;
	cout << "Game Passed!" << endl;
	return 0;
}
