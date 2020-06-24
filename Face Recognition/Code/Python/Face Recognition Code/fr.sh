#!/usr/bin/env python3
''''
Real Time Face Recogition
	==> Each face stored on dataset/ dir, should have a unique numeric integer ID as 1, 2, 3, etc                       
	==> LBPH computed model (trained faces) should be on trainer/ dir
Based on original code by Anirban Kar: https://github.com/thecodacus/Face-Recognition    

Developed by Marcelo Rovai - MJRoBot.org @ 21Feb18  
'''
import cv2
import numpy as np
import os 
import sys, termios, tty, os, time
import subprocess
import MySQLdb as mdb
from PIL import Image

con = mdb.connect('localhost', \
                    'pi', \
                    'raspberry', \
                    'main_db'); 

try:
    recognizer = cv2.face.LBPHFaceRecognizer_create()
    recognizer.read('/home/pi/FRP/trainer/trainer.yml')
    cascadePath = "/home/pi/FRP/haarcascade_frontalface_default.xml"
    faceCascade = cv2.CascadeClassifier(cascadePath);
except Exception as e:
    print (e)

font = cv2.FONT_HERSHEY_SIMPLEX

#iniciate id counter
id = 0

# Initialize and start realtime video capture
cam = cv2.VideoCapture(0)
# cv2.namedWindow('camera', cv2.WND_PROP_FULLSCREEN)
# cv2.setWindowProperty('camera', cv2.WND_PROP_FULLSCREEN, cv2.WINDOW_FULLSCREEN)

cam.set(3, 640) # set video widht
cam.set(4, 480) # set video height
# 1640x1232
# Define min window size to be recognized as a face
minW = 0.1*cam.get(3)
minH = 0.1*cam.get(4)


maximumCounter = 100

global stableId
global counter

stableId = 0
counter = 0

def selectNewStudent():
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `datasetcmd` limit 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            id_number =  row[0]
            face_id =  row[1]
            i = 1
        if i == 1:
            startingDataSet(face_id)
            trainingImages()
            deleteNewStudent(id_number)
            return True
        else:
            return False
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)

def deleteNewStudent(id_number):
    try:
        cur = con.cursor()
        sql = "DELETE FROM `datasetcmd` WHERE id = %s" % \
            (id_number)
        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)

def insertStudentLog(id_number,name,dob, mobile_number, address, status):
    try:
        cur = con.cursor()
        sql = "INSERT INTO `profile_logs`(`user_id`, `name`, `dob`, `mobile_numer`, `address`, `status`) VALUES \
         (%s,'%s','%s','%s','%s', %s)" % \
        (id_number,name,dob, mobile_number, address, status)
        
        cur.execute(sql)
        con.commit()
        # print ('Insert successfull..')

    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1) 

def insertMessage(user_id,mobile_number,message, name):
    try:
        cur = con.cursor()
        sql = "INSERT INTO `messages` (`user_id`, `mobile_number`, `message`, `name`) VALUES \
         (%s,'%s','%s','%s')" % \
        (user_id,mobile_number,message, name)
        
        cur.execute(sql)
        con.commit()
        # print ('Insert Message successfull..')

    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1) 

def selectStatus(profile_id):
    try:
        cur = con.cursor()
        sql = "SELECT `status` FROM `profile_logs` WHERE \
        user_id = %s order by id desc limit 1" % \
        (profile_id)

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            status =  row[0]
            i = 1
        if i == 1:
            if status == 0:
                return 1
            else:
                return 0
        else:
            return 1
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False

def selectMessage(name, status):
    try:
        cur = con.cursor()
        sql = "SELECT `message_in`, `message_out` FROM `sms_setting` limit 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            message_in =  row[0]
            message_out  =  row[1]
            i = 1
        if i == 1:
            if status == 0:
                return message_out % name
            else:
                return message_in % name
        else:
            return ''
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return ''

def selectProfile(profile_id):
    try:
        cur = con.cursor()
        sql = "SELECT `id`, `name` FROM `profiles` WHERE \
        id = %s limit 1" % \
        (profile_id)

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            id_number =  row[0]
            name =  row[1]
            i = 1
        if i == 1:
             return name
        else:
            return "Unkown"
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False

def selectIdentifiedProfile(profile_id):
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `profiles` WHERE \
        id = %s limit 1" % \
        (profile_id)

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            id_number =  row[0]
            registered = row[1]
            name =  row[2]
            dob = row[3]
            mobile_number = row[4]
            address = row[5]
            inOutStatus = selectStatus(profile_id)
            message = selectMessage(name, inOutStatus)
            insertStudentLog(id_number,name,dob, mobile_number, address, inOutStatus)
            insertMessage(profile_id,mobile_number,message, name)
            # print (message)
        return True
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False


def startingDataSet(face_id):

    face_detector = cv2.CascadeClassifier('/home/pi/FRP/haarcascade_frontalface_default.xml')

    print("\n [INFO] Initializing face capture. Look the camera and wait ...")
    # Initialize individual sampling face count
    count = 0

    while(True):

        ret, img = cam.read()
        img = cv2.flip(img, 1) # flip video image vertically
        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

        faces = face_detector.detectMultiScale(gray, 1.3, 5)

        for (x,y,w,h) in faces:

            cv2.rectangle(img, (x,y), (x+w,y+h), (255,0,0), 2)     
            count += 1

            # Save the captured image into the datasets folder
            cv2.imwrite("/home/pi/FRP/dataset/User." + str(face_id) + '.' + str(count) + ".jpg", gray[y:y+h,x:x+w])
        
        cv2.imshow('camera', img)
        k = cv2.waitKey(100) & 0xff # Press 'ESC' for exiting video
        if k == 27:
            break
        elif count >= 30: # Take 30 face sample and stop video
            break

# function to get the images and label data
def getImagesAndLabels(path, detector):

    imagePaths = [os.path.join(path,f) for f in os.listdir(path)]     
    faceSamples=[]
    ids = []

    for imagePath in imagePaths:

        PIL_img = Image.open(imagePath).convert('L') # convert it to grayscale
        img_numpy = np.array(PIL_img,'uint8')

        id = int(os.path.split(imagePath)[-1].split(".")[1])
        faces = detector.detectMultiScale(img_numpy)

        for (x,y,w,h) in faces:
            faceSamples.append(img_numpy[y:y+h,x:x+w])
            ids.append(id)

    return faceSamples,ids

def trainingImages():
    # Path for face image database
    path = '/home/pi/FRP/dataset'

    recognizer = cv2.face.LBPHFaceRecognizer_create()
    #recognizer = **cv2.face.LBPHFaceRecognizer_create()**
    detector = cv2.CascadeClassifier("/home/pi/FRP/haarcascade_frontalface_default.xml");
    print ("\n [INFO] Training faces. It will take a few seconds. Wait ...")
    faces,ids = getImagesAndLabels(path, detector)
    recognizer.train(faces, np.array(ids))

    # Save the model into trainer/trainer.yml
    recognizer.write('/home/pi/FRP/trainer/trainer.yml') # recognizer.save() worked on Mac, but not on Pi

    print ("\n Face Training success..")
    # Print the numer of faces trained and end program
    # print("\n [INFO] {0} faces trained. Exiting Program".format(len(np.unique(ids))))
print ("\n Facial Recognition System Started..")
while True:
    if selectNewStudent() == False:
        ret, img =cam.read()
        img = cv2.flip(img, 1) # Flip vertically
        gray = cv2.cvtColor(img,cv2.COLOR_BGR2GRAY)

        faces = faceCascade.detectMultiScale( 
            gray,
            scaleFactor = 1.2,
            minNeighbors = 5,
            minSize = (int(minW), int(minH)),
        )

        for(x,y,w,h) in faces:

            cv2.rectangle(img, (x,y), (x+w,y+h), (0,255,0), 2)

            id, confidence = recognizer.predict(gray[y:y+h,x:x+w])

            # Check if confidence is less them 100 ==> "0" is perfect match 
            confidence = round(100 - confidence)

            profile_name =  "Unknown"
            if (confidence > 40):
                profile_name =  str(selectProfile(id))
                id = id
            else:
                id = 0

            cv2.putText(img, profile_name, (x+5,y-5), font, 1, (255,255,255), 2)
            cv2.putText(img, str(confidence)+'%', (x+5,y+h-5), font, 1, (255,255,0), 1)  

            if id != stableId :
                stableId = id
                counter = 0
            else :
                if counter >= maximumCounter:
                    if id != 0:
                        selectIdentifiedProfile(id)
                        print ("Face Identified: "+profile_name)
                    counter = 0
                counter = counter + 4
            print ("Processing face " +str(counter) + ' %..')

        cv2.imshow('camera',img)
        k = cv2.waitKey(1) & 0xff # Press 'ESC' for exiting video
    else :
        recognizer = cv2.face.LBPHFaceRecognizer_create()
        recognizer.read('/home/pi/FRP/trainer/trainer.yml')
        cascadePath = "/home/pi/FRP/haarcascade_frontalface_default.xml"
        faceCascade = cv2.CascadeClassifier(cascadePath);

