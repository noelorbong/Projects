import time
import paho.mqtt.client as mqtt
import MySQLdb as mdb
# import socket  

time.sleep(20)

con = None
while True:
    try:
        con = mdb.connect('localhost', \
                        'pi', \
                        'raspberry', \
                        'data_container');
        break;          
    except Exception as e:
        print ("Error: Reconnecting database..")
        time.sleep(1)

# s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
# s.connect(("8.8.8.8", 80))

# broker_address = s.getsockname()[0]
broker_address = "localhost"
print (broker_address)
topic = "icuMonitoring/data"
client_name = "piSubscriber"
pub_client_name = "piPublisher"
# s.close()

def insertSensorData(table, value):
     if "NAN" not in value.upper():
        try:
            value = value[6:]
            cur = con.cursor()
            sql = "INSERT INTO `"+table+"`(`value`) VALUES \
            (%s)" % \
            (value)
        
            cur.execute(sql)
            con.commit()
            print ('Insert log successfull..')
        
        except Exception as e:
            con.rollback()
            print ("Error %d: %s" % (e.args[0],e.args[1]))
            #sys.exit(1)

def updateDeviceData(table, value):
        try:
            cur = con.cursor()
            sql = "Update `"+table+"` set `value`= %s" % (value)
        
            cur.execute(sql)
            con.commit()
            print ('Update log successfull..')
        
        except Exception as e:
            con.rollback()
            print ("Error %d: %s" % (e.args[0],e.args[1]))
            #sys.exit(1)

def getSMSSetting():
    enable = False
    max_temperature = None
    max_co2 = None
    try:
        cur = con.cursor()
        sql = "SELECT * FROM `device_setting` limit 1"

        cur.execute(sql)
        data = cur.fetchall()
        con.commit()
        if len(data) > 0:
          for row in data:
            if row[1] == 1:
                enable = True
            else:
                enable = False
            max_temperature = row[2]
            max_co2 = row[3]
        return enable, max_temperature,max_co2
    except mdb.Error, e:
        con.rollback()
        print "Error %d: %s" % (e.args[0],e.args[1])
        return enable, max_temperature,max_co2
        

def publishMessage(value):
    message = value
    client = mqtt.Client(pub_client_name)
    client.connect(broker_address)
    client.publish(topic, message)
    print "publishing: %s" % value

############### MQTT section ##################

# when connecting to mqtt do this;

def on_connect(client, userdata, flags, rc):
    print("Connected to "+topic+ " topic.")
    client.subscribe(topic)
    
# when receiving a mqtt message do this;

def on_message(client, userdata, msg):
    message = str(msg.payload)
    print(msg.topic+": "+message)
    enable,max_temperature, max_co2 = getSMSSetting()
    print "enable: %s" % enable
    print "max_temperature: %s" % max_temperature
    print "max_co2: %s" % max_co2
    
    if "TEMPE" in message.upper():
      insertSensorData("temperatures", message )
      if enable == True:
         print "---Enable True--"
         if float(message[6:]) >= float(max_temperature):
            # print "CTRFN:1"
            publishMessage('ctrfn:1')
            updateDeviceData("fan", 1)
         else:
            # print "CTRFN:0"
            publishMessage('ctrfn:0')
            updateDeviceData("fan", 0)
    elif "HUMID" in message.upper():
      insertSensorData("humidities",message)
    elif "COTWO" in message.upper():
      insertSensorData("co2",message)
      if enable == True:
         print "---Enable True--"
         if float(message[6:]) >= float(max_co2):
            # print "CTRAL:1"
            publishMessage('ctral:1')
            updateDeviceData("alarm", 1)
         else:
            # print "CTRAL:0"
            publishMessage('ctral:0')
            updateDeviceData("alarm", 0)




client = mqtt.Client(client_name)
client.on_connect = on_connect
client.on_message = on_message
client.connect(broker_address)
client.loop_forever()
