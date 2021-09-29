# simple-libwebsockets-example/CMakeLists.txt
# Created by Robin Rowe 2021-09-23
# License: MIT Open Source

cmake_minimum_required(VERSION 3.8)
set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)
set(CMAKE_CXX_EXTENSIONS OFF)

project(simple-libwebsockets-example)
message("Configuring ${PROJECT_NAME}...")

add_executable(simple_client client.c)
add_executable(simple_server server.c)
