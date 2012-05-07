#!/bin/sh
dnsspoof -i br-lan -f /var/www/crossfire/config/spoofhost > /dev/null 2>/var/www/crossfire/logs/dnsspoof.log
