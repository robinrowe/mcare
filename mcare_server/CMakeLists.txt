# McareServer/CMakeLists.txt
# Created by Robin Rowe 2021-08-15
# License: MIT Open Source

cmake_minimum_required(VERSION 3.8)
set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)
set(CMAKE_CXX_EXTENSIONS OFF)

project(McareServer)
message("Configuring ${PROJECT_NAME}...")
enable_testing()
file(STRINGS sources.cmake SOURCES)
add_library(${PROJECT_NAME}_lib ${SOURCES})
link_libraries(${PROJECT_NAME}_lib)
if(NOT WIN32 AND NOT APPLE)
	link_libraries(rt pthread)
endif(NOT WIN32 AND NOT APPLE)

option(UNISTD "Enable libunistd" false)
if(UNISTD)
	set(LIBUNISTD_PATH /code/github/libunistd)
	if(WIN32)
		include_directories(${LIBUNISTD_PATH}/unistd)
		link_directories(${LIBUNISTD_PATH}/build/unistd/Release)
		link_libraries(libunistd)
	endif(WIN32)
endif(UNISTD)

option(FLTK "Enable FLTK" false)
if(FLTK)
	set(FLTK_PATH /Code/fltk)
	include_directories(${FLTK_PATH} ${FLTK_PATH}/fltk-build ${FLTK_PATH}/fltk-src/)
	link_directories(${FLTK_PATH}/fltk-src/build/lib/Debug)
	set(FLTK_LIBS
		fltk_formsd
		fltk_gld
		fltk_imagesd
		fltk_jpegd
		fltk_pngd
		fltk_zd
		fltkd
	)
	link_libraries(${FLTK_LIBS} comctl32)
endif(FLTK)

add_executable(test_GameServer test/test_GameServer.cpp)
add_test(test_GameServer test_GameServer)
add_executable(test_Player test/test_Player.cpp)
add_test(test_Player test_Player)
add_executable(test_Players test/test_Players.cpp)
add_test(test_Players test_Players)
add_executable(test_Game test/test_Game.cpp)
add_test(test_Game test_Game)
add_executable(test_Games test/test_Games.cpp)
add_test(test_Games test_Games)
add_executable(test_Hospital test/test_Hospital.cpp)
add_test(test_Hospital test_Hospital)
add_executable(test_Hospitals test/test_Hospitals.cpp)
add_test(test_Hospitals test_Hospitals)
add_executable(test_Lobby test/test_Lobby.cpp)
add_test(test_Lobby test_Lobby)
add_executable(test_Login test/test_Login.cpp)
add_test(test_Login test_Login)
add_executable(test_Packet test/test_Packet.cpp)
add_test(test_Packet test_Packet)
add_executable(test_Connection test/test_Connection.cpp)
add_test(test_Connection test_Connection)
add_executable(test_MsgQueue test/test_MsgQueue.cpp)
add_test(test_MsgQueue test_MsgQueue)
add_executable(test_Mola test/test_Mola.cpp)
add_test(test_Mola test_Mola)
add_executable(test_Action test/test_Action.cpp)
add_test(test_Action test_Action)
add_executable(test_Timer test/test_Timer.cpp)
add_test(test_Timer test_Timer)
add_executable(test_Replay test/test_Replay.cpp)
add_test(test_Replay test_Replay)
add_executable(mcare_server mcare_server.cpp)
