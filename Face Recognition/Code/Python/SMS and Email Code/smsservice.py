import time, sys
from datetime import datetime, date
import CCgsm
import MySQLdb as mdb
# import hardwares as hw

time.sleep(20)

con = mdb.connect('localhost', \
                    'pi', \
                    'raspberry', \
                    'main_db'); 


def selectMessage():
    try:
        cur = con.cursor()
        sql = "SELECT `enable` FROM `sms_setting` limit 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        i = 0
        for row in data:
            enable =  row[0]
            i = 1
        if i == 1:
            return enable
        else:
            return 0
    except mdb.Error as e:
        con.rollback()
        print ("Error %d: %s" % (e.args[0],e.args[1]))
        sys.exit(1)
        return 0

def getMessageToBeSend():
    id = None
    number = None
    message = None
    user = None
    try:
        cur = con.cursor()
        sql = "SELECT `id`, `user_id`,`mobile_number`, `message`, `name` FROM `messages` WHERE \
                created_at < now() ORDER BY id asc limit 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        if len(data) > 0:
          for row in data:
              id = row[0]
              user_id = row[1]
              mobile_number = row[2]
              message = row[3]
              name = row[4]

              sendMessage(id, user_id, mobile_number, message, name)
    except mdb.Error, e:
        con.rollback()
        print "Error %d: %s" % (e.args[0],e.args[1])
        sys.exit(1)

def sendMessage(id, user_id, mobile_number, message, name):
    print '   '
    print 'Sending Message:'
    print '     Number: %s' % mobile_number
    print '     Message: %s' % message
    response = CCgsm.sendMessage(mobile_number, message)
    if response == 'Sending Failed':
        print response
        insertSentMessage(mobile_number, message, 0,name,user_id)       
    else:
        print response
        insertSentMessage(mobile_number, message, 1,name,user_id)     
    deleteSentMessage(id)


def insertSentMessage(messageto, message,status, user, user_id):
    try:
        message= message.replace("'", "''")
        cur = con.cursor()

        sql = "INSERT INTO `sent_messages`(`number`, `message`, `sent`, `name`, `user_id`) VALUES \
         ('%s','%s',%s,'%s',%s)" % \
        (messageto,message,status,user,user_id)
        
        cur.execute(sql)
        con.commit()
        #print 'Insert successfull..'

    except mdb.Error, e:
        con.rollback()
        print "Error %d: %s" % (e.args[0],e.args[1])
        sys.exit(1)

def deleteSentMessage(id):
    try:
        cur = con.cursor()

        sql = "DELETE From `messages` WHERE \
        id = %s " % \
        (id)

        cur.execute(sql)
        con.commit()
        #print 'Delete log successfull..'

    except mdb.Error, e:
        con.rollback()
        print "Error %d: %s" % (e.args[0],e.args[1])
        sys.exit(1)


CCgsm.restart()
time.sleep(5)
CCgsm.textmode()
time.sleep(10)
while True:
    if selectMessage() == 1:
        getMessageToBeSend()
    time.sleep(1)


