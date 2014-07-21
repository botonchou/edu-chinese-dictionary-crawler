#!/bin/bash -e

if [ "$1" == "" ] || [ "$2" == "" ]; then
  echo "Usage: ./go_parse.sh crawled-data-dir output-dictionary-file"
  exit -1
fi

DIR=$1
dict=$2

mkdir -p $DIR/filtered

TEMP=`mktemp`
for file in $(grep "width=\"90%\"" $DIR/html/*.txt -l | sort -n); do
  # echo $file
  output=$DIR/filtered/$(basename $file)
  scripts/filter1.sh <(iconv -f big5 -t utf-8 $file | tr '\n' ' ' | perl -pe "s/.*<table width=\"90%\"[^>]*>(.*)<\/table>.*/<table>\1<\/table>/g") $output
  [ "$(grep "<" $output)" ] && cp $output $TEMP && scripts/filter2.sh $TEMP $output
done

cd $DIR/filtered/ && cat `ls | sort -n` > ../../$dict && cd -
