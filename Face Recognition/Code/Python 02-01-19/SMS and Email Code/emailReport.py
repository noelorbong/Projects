import smtplib
from email.MIMEMultipart import MIMEMultipart
from email.MIMEText import MIMEText
import MySQLdb as mdb
import time, sys
import datetime
from datetime import timedelta 

time.sleep(25)

con = mdb.connect('localhost', \
                    'pi', \
                    'raspberry', \
                    'main_db'); 

def selectEmailSetting():
    emailSetting = ['','','','','','']
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
            emailSetting[4] = row[5]
            emailSetting[5] = row[6]
            i = 1
        if i == 1:
            if emailSetting[4] == 1 :
                return True, emailSetting
            else:
                return False, emailSetting
        else:
            return False, emailSetting
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False, emailSetting

def selectEmail():
    emailData = ['','','','','','','']
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `send_email` limit 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            emailData[0] = row[0]
            emailData[1] = row[1]
            emailData[2] = row[2]
            emailData[3] = row[3]
            emailData[4] = row[4]
            emailData[5] = row[5]
            emailData[6] = row[6]
            i = 1
        if i == 1:
            return True, emailData 
        else:
            return False, emailData
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False, emailData

def deleteEmail(id):
    try:
        cur = con.cursor()
        sql = "delete from `send_email` where \
            id = %s" % id

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        return "success"
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return "failed"


def selectLog(s_date,e_date):
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `profile_logs` where \
            DATE(created_at) >= '%s' and DATE(created_at) <= '%s' order by id desc" % (s_date,e_date)
        
        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        print len(data)
        trow = ""
        for row in data:
            trow += "<tr style=\"  color: #23282c; display: table; width: 100%; table-layout: fixed;\">"
            trow += "<th>" + str(row[2]) + "</th>"
            trow += "<th>" + str(row[3]) + "</th>"
            trow += "<th>" + str(row[4]) + "</th>"
            trow += "<th>" + str(row[5]) + "</th>"
            trow += "<th>" + str(row[6]) + "</th>"
            trow += "<th>" + str(row[7]) + "</th>"
            inOut = "In"
            if row[8] == 1:
                inOut = "In"
            elif row[8] == 0: 
                inOut = "Out"
            else:
                inOut = "Unknown"
            trow += "<th>" + str(inOut) + "</th>"
            trow += "<th>" + str(row[9]) + "</th>"
            trow += "</tr>"

        if len(data) > 0: 
            # print trow
            return True, trow
        else:
            return False, ""
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False, ""

def selectLog2(grade_level,section,s_date,e_date):
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `profile_logs` where \
            grade_level = '%s' and section = '%s' and \
            DATE(created_at) >= '%s' and DATE(created_at) <= '%s' order by id desc " % (grade_level,section,s_date,e_date)
        
        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        print len(data)
        trow = ""
        for row in data:
            trow += "<tr style=\"  color: #23282c; display: table; width: 100%; table-layout: fixed;\">"
            trow += "<th>" + str(row[2]) + "</th>"
            trow += "<th>" + str(row[3]) + "</th>"
            trow += "<th>" + str(row[4]) + "</th>"
            trow += "<th>" + str(row[5]) + "</th>"
            trow += "<th>" + str(row[6]) + "</th>"
            trow += "<th>" + str(row[7]) + "</th>"
            inOut = "In"
            if row[8] == 1:
                inOut = "In"
            elif row[8] == 0: 
                inOut = "Out"
            else:
                inOut = "Unknown"
            trow += "<th>" + str(inOut) + "</th>"
            trow += "<th>" + str(row[9]) + "</th>"
            trow += "</tr>"

        if len(data) > 0: 
            # print trow
            return True, trow
        else:
            return False, ""
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return False, ""


def sendEmail(emailSetting, s_date,e_date,e_type,grade_level,section):
    if e_type == 0:
        hasLog, trow = selectLog(s_date,e_date)
    else:
        hasLog, trow = selectLog2(grade_level,section,s_date,e_date)

    if hasLog == False:
        print "No Log"
        return

    with open('email.html', 'r') as myfile:
        data=myfile.read()

    data = data.format(trow)

    fromaddr = emailSetting[0]
    frompsk = emailSetting[1]
    toaddr = emailSetting[2]
    msg = MIMEMultipart()
    msg['From'] = fromaddr
    msg['To'] = toaddr
    msg['Subject'] = emailSetting[3]

    body = data
    msg.attach(MIMEText(body, 'html'))

    server = smtplib.SMTP('smtp.gmail.com', 587)
    server.starttls()
    server.login(fromaddr, frompsk)
    text = msg.as_string()
    server.sendmail(fromaddr, toaddr, text)
    server.quit()

    print "Email Success"
    return


c_date = datetime.date.today() - timedelta(days=1) 

while True: 
    isEnabled, emailSetting = selectEmailSetting()
    c_time =  (time.strftime("%H:%M:%S"))
    s_time = emailSetting[5]
    if isEnabled == True:
        if c_date != datetime.date.today():
            if c_time > str(s_time) :

                c_date = datetime.date.today()
                sendEmail(emailSetting, datetime.date.today(),datetime.date.today(),0,'','')
                
    isData, emailData = selectEmail()
    if isData == True:
        print emailData[0] 
        print emailData[1] 
        print emailData[2] 
        print emailData[3]
        print emailData[4]
        print emailData[5]
        print emailData[6]
        emailSetting[2] = emailData[1]
        sendEmail(emailSetting, emailData[2],emailData[3],emailData[4],emailData[5],emailData[6])
        deleteEmail(emailData[0])
    time.sleep(1)



