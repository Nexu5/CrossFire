#!/bin/sh
# -----------------------------------------------------------------
# Simple script to check if SSH is connected and restart it if not.
# -----------------------------------------------------------------
logger "SSH: Keep-Alive Script Executed"
if ! ( pidof autossh); then
	/www/pineapple/ssh/ssh-connect.sh &
	logger "SSH: Connection seemed to be down. Issued /www/pineapple/ssh/ssh-connect.sh"
else
	logger "SSH: Connection seems to be up."
fi
