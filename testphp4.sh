#!/bin/bash

clear
# set -o pipefail
inotifywait -m --format %w%f -q -r -e close_write $1 $2 --exclude '/\..+|README' | \
while read CUAL 
do
        if [ $? == 0 ]; then
                clear
#               unbuffer /home/rudy/bin/phpunit --color --strict-coverage $1 |tee  >( tail -n 1 | sed -r "s/\x1B\[([0-9]{1,2}(;[0-9]{1,2})?)?[m|K]//g" > README )
/home/rudy/bin/phpunit --color --strict-coverage $1 
##              echo ${PIPESTATUS[@]};
#               if [ ${PIPESTATUS[0]} == 0 ]; then
                if [ $? == 0 ]; then
                        git add .
                        git commit -m "autocommit por pruebas sin fallar"
                fi
        fi
done 

