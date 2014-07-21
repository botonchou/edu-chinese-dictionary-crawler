#!/bin/bash -e

mkdir -p data/{filtered,html}
chmod o+w data/html

printf "\33[32m[Done]\33[0m Directories data/filtered, data/html created.\n"
printf "       Apache and PHP5 is needed. You can install them using:\n"
printf "       \33[33msudo apt-get install php5 libapache2-mod-php5 php5-mcrypt\33[0m\n"
printf "       After that, open index.html using google-chrome.\n"
