import RPi.GPIO as GPIO
import serial
import time, sys
import datetime
import time, sys
from time import *

def setup():
    GPIO.setmode(GPIO.BCM)
    GPIO.setwarnings(False)
    GPIO.setup(22, GPIO.OUT)
    GPIO.setup(23, GPIO.OUT)
    GPIO.setup(24, GPIO.OUT)
    GPIO.setup(25, GPIO.OUT)

def switch(pin_no, action):
    setup()
    if action == 'on':
        GPIO.output(int(pin_no),GPIO.HIGH)
        response = 'success'
    elif action == 'off':
        GPIO.output(int(pin_no),GPIO.LOW)
        response = 'success'
    else:
        response = 'failed'

    return response

def toggle(pin_no, time):
    setup()
    GPIO.output(int(pin_no),GPIO.HIGH)
    sleep(int(time))
    GPIO.output(int(pin_no),GPIO.LOW)
    return 'success'

       