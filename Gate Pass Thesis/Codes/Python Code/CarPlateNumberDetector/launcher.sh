#!/bin/sh
# launcher.sh
# navigate to home directory, then to this directory, then execute python script, then back home

cd /
cd home/pi/Authentication/CarPlateNumberDetector
sudo python3 authgate.py
cd /
