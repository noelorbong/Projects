import rfidreader as rr
#import //Getplatenumber as gpn
import os
import sys
import time
import serial
import MySQLdb as mdb
# sys.path.insert(0, '/home/pi/Authentication/CarPlateNumberDetector')
import Getplatenumber as gpn
import hardwares as hw
import subprocess
    #username
    #password
    #database
time.sleep(30)

con = mdb.connect('localhost', \
                    'gatepass', \
                    'gatepasskey', \
                    'gatepass'); 

SERIAL_PORT = "/dev/ttyS0"    # Rasp 3 UART Port
ser = serial.Serial(SERIAL_PORT, baudrate = 9600, timeout = 5)

def rfidConnection():
    i = 0;
    ii = 1;
    connection = None
    while True:
        try:
            connection = open('/dev/hidraw'+str(i), 'rb')
            break;
        except Exception as e:
            i= i+1
            if i >= ii:
                i = 0
                ii = ii+1
            print (e)
            time.sleep(2)
    print ("Connected..")
    return connection

fp = rfidConnection()

def selectRfid(rfid_no):
    try:
        cur = con.cursor()
        sql = "SELECT `id` FROM `rfidaccounts` WHERE \
        rfid_no = '%s'" % \
        (rfid_no)

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            user_id = row[0]
            i = 1
        if i == 1:
             print ("User "+ str(user_id) +" in Database")
             #print user_id
             #insertRfidLog(user_id, rfid_no)
             return True
        else:
            print ("Uknown RFID")
            #insertRfidLog(0, rfid_no)
            return False
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False

def updatePlate(rfid_no):
    try:
        cur = con.cursor()
        sql = "UPDATE `plate_detected` SET `plate_number`='%s',`updated_at`=NOW() WHERE 1" % \
        (rfid_no)

        cur.execute(sql)
        con.commit()
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False

def getPlateNo():
    print ("Stop Motion Cam")
    subprocess.call(["sudo","service","motion","stop"]) 
    #os.system("sudo service motion stop")
    print ("Starting To take Photo..")
    #time.sleep(1)
    subprocess.call(["sudo", "raspistill", "-t", "2000", "-o", "/var/www/web/public/img/plate/1.jpg", "-w", "1640", "-h", "1232"]) 
    #os.system("sudo raspistill -t 2000 -o /var/www/web/public/img/plate/1.jpg -w 1640|3280 -h 1232|2464")
    #time.sleep(1)
   
    #os.system("sudo service motion start")
    plate_numbers = ["error"]
    # time.sleep(1)
    try:
        plate_numbers = gpn.main()
        i = 0
        strPlates = ""
        while i < len(plate_numbers):
            if plate_numbers[i].strip() != "":
                strPlates = strPlates + plate_numbers[i]+","
            i = i +1

        print ("Start Motion Cam")
        subprocess.call(["sudo", "service", "motion", "start"]) 
        updatePlate(strPlates.strip())
    except Exception as e:
        print ("Start Motion Cam")
        subprocess.call(["sudo", "service", "motion", "start"]) 
        updatePlate("No Plate Number Detected ")
        print (e)

    
    return plate_numbers
    #return "LR33 TEE" 

def checkPlateNos(rfid_no, plate_nos, state):
    i = 0
    while i < len(plate_nos):
        isInData = checkPlateNo(rfid_no, plate_nos[i], state)
        i = i+1
        if isInData == True:
            return True
    return False

def checkPlateNo(rfid_no, plate_no, state):
    try:
        cur = con.cursor()
        sql = "SELECT `id` FROM `rfidaccounts` WHERE \
        rfid_no = '%s' and plate_no = '%s'" % \
        (rfid_no, plate_no )

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            user_id = row[0]
            i = 1
        if i == 1:
             
             insertRfidLog(user_id, rfid_no, state)
             return True
        else:
            print ("Uknown Car")
            #insertRfidLog(0, rfid_no, state)
            return False
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False
    
def checkedRfidState(rfid_no):
    try:
        cur = con.cursor()
        sql = "SELECT `state` FROM `rfid_account_logs` WHERE rfid_no = '%s' order by id desc limit 1" % \
        (rfid_no)

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            state = row[0]
            i = 1
        if i == 1:
             
             if state == 1:
                print ("Going Outside")
                return 0
             else:
                print ("Going Inside")
                return 1
        else:
            print ("RFID has no History")
            print ("Going Inside")
            return 0
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)

def insertRfidLog(user_id, rfid_no, state):
    try:
        cur = con.cursor()

        sql = "INSERT INTO `rfid_account_logs`(`user_id`, `rfid_no`, `state`) VALUES \
         ('%s','%s',%s)" % \
        (user_id,rfid_no,state)
        
        cur.execute(sql)
        con.commit()
        print ('Insert successfull..')

    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)    

def openBarrier(state):
    hardwareResponse = hw.switch(22, "off")
    hardwareResponse = hw.switch(23, "off")
    hardwareResponse = hw.switch(24, "on")
    hardwareResponse = hw.switch(25, "off")
    command = ''
    if state == 0:
        command = 'outopen'
    else:
       command = 'inopen'
    print (command)
    ser.write(command.encode())
    rr.rfidReader(fp, True)
    while True:
        reply = ser.readline()
        if "gateclosed".encode() in reply.lower():
            print (reply)
            break;
        if "".encode() != reply.lower():
            print (reply)
            # break;
        time.sleep(.500)
        
    return True;    

while True:
    try:
       hardwareResponse = hw.switch(22, "off")
       hardwareResponse = hw.switch(23, "off")
       hardwareResponse = hw.switch(24, "off")
       hardwareResponse = hw.switch(25, "on")
       rfidNumber = rr.rfidReader(fp, False)
       
       if rfidNumber != '':
        # dirPath = "/var/www/web/public/img/plate"
        # fileList = os.listdir(dirPath)
        # for fileName in fileList:
        #         os.remove(dirPath+"/"+fileName)
        print ("RFID Number: "+ rfidNumber)
        if selectRfid(rfidNumber) == True:
            hardwareResponse = hw.switch(22, "on")
            hardwareResponse = hw.switch(23, "off")
            hardwareResponse = hw.switch(24, "off")
            hardwareResponse = hw.switch(25, "off")
            plate_nos = getPlateNo()
            # print (plate_no)
            state = checkedRfidState(rfidNumber)
            reply = ser.readline()
            if checkPlateNos(rfidNumber, plate_nos, state) == True:
                print ("Success")
                openBarrier(state)
            else:
                print ("Plate does not match")
                hardwareResponse = hw.switch(22, "off")
                hardwareResponse = hw.switch(23, "on")
                hardwareResponse = hw.switch(24, "off")
                hardwareResponse = hw.switch(25, "off")
        else:
            hardwareResponse = hw.switch(22, "off")
            hardwareResponse = hw.switch(23, "on")
            hardwareResponse = hw.switch(24, "off")
            hardwareResponse = hw.switch(25, "off")
       rfidNumber = ''
       time.sleep(1)
    except Exception as e:
       print ("Connection Lost..")
       print ("Retrying Connection...")
       print (e)
       hardwareResponse = hw.switch(22, "off")
       hardwareResponse = hw.switch(23, "off")
       hardwareResponse = hw.switch(24, "off")
       hardwareResponse = hw.switch(25, "off")
       time.sleep(1)
       fp = rfidConnection()
