import serial
import time, sys

SERIAL_PORT = "/dev/ttyS0"    # Rasp 3 UART Port
ser = serial.Serial(SERIAL_PORT, baudrate = 115200, timeout = 5)

def textmode():
    ser.write("AT+CMGF=1\r")
    time.sleep(3)
    reply = ser.read(ser.inWaiting())
    ii = 0
    while "OK" not in reply.upper():
        reply = ser.read(ser.inWaiting())
        print "waiting...."
        time.sleep(0.5)
        if ii == 20:         
            break
        ii +=1
    print "textmode on"
    reply = ""

def restart():
    ser.write("AT+CFUN=0\r")
    time.sleep(0.5)
    reply = ser.read(ser.inWaiting())
    ii = 0
    while "OK" not in reply.upper():
        reply = ser.read(ser.inWaiting())
        print "rebooting...."
        time.sleep(0.5)
        if ii == 20:
            ii = 0         
            break
        ii +=1
    reply = ""
    ser.write("AT+CFUN=1\r")
    time.sleep(0.5)
    reply = ser.read(ser.inWaiting())
    ii = 0
    while "OK" not in reply.upper():
        reply = ser.read(ser.inWaiting())
        print "starting...."
        time.sleep(0.5)
        if ii == 20:
            ii = 0         
            break
        ii +=1
    print "GSM Started"
    reply = ""

def sendMessage(number, msg):
    ser.write('AT+CMGS="%s"\r' % number)
    time.sleep(0.5)
    ser.write(msg + chr(26))
    time.sleep(1)
    reply = ser.read(ser.inWaiting())
    print reply
    # if "ERROR" in reply.upper():
    #     reply = "Sending Failed"
    #     return reply
    i = 3
    ii = 0
    while True:
        try:
            reply = ser.read(ser.inWaiting())
            response = reply.splitlines()[i]
            break
        except Exception:
            print 'Waiting for Response..'
            i = 1
            time.sleep(0.5)
            if ii == 30:
                reply = "ERROR"
                break
            ii +=1
    if "ERROR" in reply.upper():
        reply = "Sending Failed"
    else:
        reply = "Message Sent"
    return reply