#!/bin/sh
# launcher2.sh
# navigate to home directory, then to this directory, then execute python script, then back home

cd /
cd home/pi/sms
sudo python emailReport.py
cd /
