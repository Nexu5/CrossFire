#!/bin/sh
while true
do
#echo '' > /var/www/crossfire/ngrep-clean.log
cat /tmp/ngrep.log | grep -e "Host:" -e "Cookie:" >> /var/www/crossfire/ngrep-clean.log
echo '' > /tmp/ngrep.log
sleep 10
done
