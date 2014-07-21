#!/bin/bash -e

in=$1
out=$2
sed $in \
  -e "s%<table[^>]*>%%g"\
  -e "s%</table>%%g"\
  -e "s%<tr>[^<]*<td[^>]*>[^<]*</td>%%g"\
  -e "s%<td[^>]*>[^<]*<a href[^>]*>%%g"\
  -e "s%</a>\|<td>\|</td>%%g"\
  -e "s%<img[^>]*>%%g"\
  -e "s%</tr>%\n%g"\
  -e "s%　% %g"\
  -e "s%  \|&nbsp;%%g"\
  -e "s%\n %\n%g" > $out
