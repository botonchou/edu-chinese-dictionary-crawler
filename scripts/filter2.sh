#!/bin/bash -e
in=$1
out=$2

word=$(head -n 1 $in | sed "s%.*<span class=\"key\">\([^<]*\)</span>.*%\1%i")
pron=$(head -n 2 $in | tail -n 1 | sed "s%.*<span class=\"lable\">.*</span> %%g")
echo "$word $pron" > $out
