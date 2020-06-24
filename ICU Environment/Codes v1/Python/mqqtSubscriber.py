import time
import paho.mqtt.client as mqtt
import MySQLdb as mdb
import socket  

#time.sleep(30)

con = mdb.connect('localhost', \
                    'pi', \
                    'raspberry', \
                    'data_container');

s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
s.connect(("8.8.8.8", 80))

broker_address = s.getsockname()[0]
print broker_address
topic = "icuMonitoring/data"
client_name = "piSubscriber"
s.close()

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
            print 'Insert log successfull..'
        
        except mdb.Error, e:
            con.rollback()
            print "Error %d: %s" % (e.args[0],e.args[1])
            #sys.exit(1)
        


############### MQTT section ##################

# when connecting to mqtt do this;

def on_connect(client, userdata, flags, rc):
    print("Connected to "+topic+ " topic.")
    client.subscribe(topic)
    
# when receiving a mqtt message do this;

def on_message(client, userdata, msg):
    message = str(msg.payload)
    print(msg.topic+": "+message)

    if "TEMPE" in message.upper():
        insertSensorData("temperatures", message )
    elif "HUMID" in message.upper():
       insertSensorData("humidities",message)
    elif "CTRFN" in message.upper():
       insertSensorData("fan",message)
    elif "CTRAL" in message.upper():
       insertSensorData("alarm",message)
    elif "COTWO" in message.upper():
       insertSensorData("co2",message)


client = mqtt.Client(client_name)
client.on_connect = on_connect
client.on_message = on_message
client.connect(broker_address)
client.loop_forever()