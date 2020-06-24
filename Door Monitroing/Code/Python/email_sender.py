import smtplib
from email.MIMEMultipart import MIMEMultipart
from email.MIMEText import MIMEText
from email.MIMEBase import MIMEBase
from email import encoders
from time import sleep
import MySQLdb as mdb
import RPi.GPIO as GPIO
from shutil import copyfile
import CCgsm

sleep(20)

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(24, GPIO.IN)         #Read output from PIR motion sensor
GPIO.setup(23, GPIO.OUT)         #LED output pin

con = mdb.connect('localhost', \
                    'pi', \
                    'raspberry', \
                    'main_db'); 

def selectEmailSetting():
    emailSetting = ['','','','']
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `email_setting` limit 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            emailSetting[0] = row[1]
            emailSetting[1] = row[2]
            emailSetting[2] = row[3]
            emailSetting[3] = row[4]
            i = 1
        if i == 1:
            if emailSetting[0] == 1 :
                return True, emailSetting
            else:
                return False, emailSetting
        else:
            return False, emailSetting
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        return False, emailSetting

def selectSMSSetting():
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `sms_setting` limit 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            enable = row[1]
            message = row[2]
            i = 1
        if i == 1:
            if enable == 1 :
                return True, message
            else:
                return False, ""
        else:
            return False, ""
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        return False, ""

def selectEmailSubscriber(emailSetting):
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `email_subscribers` where active = 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            sub_id = row[0]
            sub_name = row[2]
            sub_email = row[3]
            if sendEmail(emailSetting,sub_email) == True:
                insertEmailLog(sub_id, sub_name, sub_email, emailSetting[3], 1)
            else:
                insertEmailLog(sub_id, sub_name, sub_email, emailSetting[3], 0)
            i = 1
        if i == 1:
            return True
        else:
            return False
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        return False

def selectSMSSubscriber(message):
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `sms_subscribers` where active = 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            sub_id = row[0]
            sub_name = row[2]
            sub_number = row[3]
            if sendMessage(sub_number,message) == True:
                insertSMSLog(sub_id, sub_name, sub_number, message, 1)
                print 'Insert Sent Message'
            else:
                insertSMSLog(sub_id, sub_name, sub_number, message, 0)
                print 'Insert Failed Message'
            i = 1
        if i == 1:
            return True
        else:
            return False
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        return False

def insertEmailLog(sub_id, sub_name, sub_email, sub_subject, sub_sent):
    sub_subject= sub_subject.replace("'", "''")
    try:
        cur = con.cursor()
        sql = "INSERT INTO `email_log` (`subscriber_id`, `name`, `email`, `subject`, `sent`) \
        VALUES (%s, '%s', '%s', '%s', %s)" % \
              (sub_id, sub_name, sub_email, sub_subject, sub_sent)

        cur.execute(sql)
        con.commit()
        return True
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        return False

def insertSMSLog(sub_id, sub_name, sub_number, sub_message, sub_sent):
    sub_message= sub_message.replace("'", "''")
    try:
        cur = con.cursor()
        sql = "INSERT INTO `sms_log` (`subscriber_id`, `name`, `number`, `message`, `sent`) \
        VALUES (%s, '%s', '%s', '%s', %s)" % \
              (sub_id, sub_name, sub_number, sub_message, sub_sent)

        cur.execute(sql)
        con.commit()
        return True
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        return False

def insertInstance():
    try:
        cur = con.cursor()
        sql = "INSERT INTO `instace_counter` (`counter`) VALUES (1)"
        cur.execute(sql)
        con.commit()
        return True
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        return False         

def sendMessage(sub_number, message):
    print '   '
    print 'Sending Message:'
    print '     Number: %s' % sub_number
    print '     Message: %s' % message
    response = CCgsm.sendMessage(sub_number, message)
    if response == 'Sending Failed':
        print response
        return False       
    else:
        print response
        return True

def sendEmail(emailSetting, sub_email):
    try:
        fromaddr =  emailSetting[1]
        password =  emailSetting[2]
        toaddr = sub_email
        
        msg = MIMEMultipart()
        
        msg['From'] = fromaddr
        msg['To'] = toaddr
        msg['Subject'] = emailSetting[3]
        
        body =  ''
        
        msg.attach(MIMEText(body, 'plain'))
        
        filename = "image.jpg"
        attachment = open("/home/pi/python/images/image.jpg", "rb")
        
        part = MIMEBase('application', 'octet-stream')
        part.set_payload((attachment).read())
        encoders.encode_base64(part)
        part.add_header('Content-Disposition', "attachment; filename= %s" % filename)
        
        msg.attach(part)
        
        server = smtplib.SMTP('smtp.gmail.com', 587)
        server.starttls()
        server.login(fromaddr,  password)
        text = msg.as_string()
        server.sendmail(fromaddr, toaddr, text)
        server.quit()
        print "Email sent to %s." % toaddr
        return True
    except Exception as e:
        print "Email failed sending.."
        print e
        return False
    
def sendViaEmail():
    isEnabled, emailSetting = selectEmailSetting()
    if isEnabled == True:
        src = "/var/lib/motioneye/Camera1/image.jpg"
        dst = "/home/pi/python/images/image.jpg"
        copyfile(src, dst)
        print emailSetting[1]
        print emailSetting[2]
        selectEmailSubscriber(emailSetting)

def sendViaSMS():
    isEnabled, message = selectSMSSetting()
    if isEnabled == True:
        print isEnabled
        print message
        selectSMSSubscriber(message)

hasIntruder = False
CCgsm.restart()
CCgsm.textmode()


while True:
    i=GPIO.input(24)
    if i==0:                 #When output from motion sensor is LOW
        #print "No intruders",i
        GPIO.output(23, GPIO.LOW)  #Turn OFF LED
        sleep(0.1)
        hasIntruder = True
    elif i==1:               #When output from motion sensor is HIGH
        if hasIntruder == True:
            print "Intruder detected",i
            GPIO.output(23, GPIO.HIGH)  #Turn ON LED
            hasIntruder = False
            insertInstance()
            sendViaEmail()
            sendViaSMS()
        sleep(0.1)
