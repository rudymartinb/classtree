#!/bin/bash

# run this script from the root dir of the project
# on a konsole window or xterm
# like this:
# $ testphp4.sh tests/testsSuite.php .
# each time you save the files it will run the tests
 
clear
inotifywait -m --format %w%f -q -r -e close_write $1 $2 --exclude '/\..+|README' | \
while read CUAL 
do
	if [ $? == 0 ]; then
		clear
		phpunit --color --strict-coverage $1
		if [ $? == 0 ]; then
			# remove this coments if you want to make a fork
            # git add .
            # git commit -m "autocommit on successful tests run"
		fi
	fi
done 

