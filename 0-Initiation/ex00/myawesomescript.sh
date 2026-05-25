#!/bin/sh

if [ $# != 1 ]; then
	exit 1
fi

curl -I "$1" | grep -i "location" | cut -d " " -f 2

