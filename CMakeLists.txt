# MCARE/CMakeLists.txt
# Created by Robin Rowe 2021-08-26
# License MIT License

cmake_minimum_required(VERSION 3.8)
set(CMAKE_CXX_STANDARD 17)
set(CMAKE_CXX_STANDARD_REQUIRED ON)
set(CMAKE_CXX_EXTENSIONS OFF)

set(Project MCARE)
project(${Project})

# Note: It is necessary to explicitly copy the option command from the subdirectory CMakeLists.txt as otherwise when executing CMake configuration initially the value of the variable would first be set by the set command and later the value would be overwritten by the option command because there was no value in the cache. 

#add_subdirectory(openssl)
option(LWS_WITH_SSL "Include SSL support (defaults to OpenSSL or similar, mbedTLS if LWS_WITH_MBEDTLS is set)" ON)
set(LWS_WITH_SSL OFF)
option(LWS_WITH_SHARED "Build the shared version of the library" ON)
set(LWS_WITH_SHARED OFF)
add_subdirectory(libwebsockets)
include_directories(
	${CMAKE_SOURCE_DIR}/libwebsockets/include 
	${CMAKE_BINARY_DIR}/libwebsockets/include	)
link_directories(
	${CMAKE_BINARY_DIR}/libwebsockets/lib/Debug	)
link_libraries(Ws2_32 websockets_static)
add_subdirectory(mcare_server)
add_definitions(-D_CRT_SECURE_NO_WARNINGS)
add_subdirectory(simple-libwebsockets-example)
