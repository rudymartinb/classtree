#!/bin/bash
clear

inotifywait -m --format %w%f -q -r -e close_write $1 $2 --exclude '/\..+|README' | \
while read CUAL 
do
        if [ $? == 0 ]; then
                clear
				phpunit --color --strict-coverage $1 
                if [ $? == 0 ]; then
                        git add .
                        git commit -m "autocommit por pruebas sin fallar"
                fi
        fi
done 

