#!/bin/bash

# run this script from the root dir of the project
# on a konsole window or xterm
# like this:

# 	$ scripts/testphp4.sh tests/testsSuite.php .

# each time you save the files it will run the tests
 
clear
inotifywait -m --format %w%f -q -r -e close_write src tests --exclude '/\..+|README|documentation\*.txt' | \
while read CUAL 
do
	if [ $? == 0 ]; then
		clear
		phpunit --color --strict-coverage $1
		if [ $? == 0 ]; then
			message=$(echo -n "autocommit: " ; cat documentation/last_commit.txt)
            git add .
            git commit -m "$message"
		fi
	fi
done 

