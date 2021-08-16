// test_Packet.cpp 
// Created by Robin Rowe 2021-08-15
// MIT Open Source

#include <iostream>
#include "../Packet.h"
using namespace std;

int main(int argc,char* argv[])
{	cout << "Testing Packet" << endl;
	Packet packet;
	if(!packet)
	{	cout << "Packet failed on operator!" << endl;
		return 1;
	}
	cout << packet << endl;
	cout << "Packet Passed!" << endl;
	return 0;
}
