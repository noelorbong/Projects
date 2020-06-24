// included libraries
#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <SPI.h>
#include <Wire.h> 
#include "DHT.h"
#include "Adafruit_CCS811.h"
#include <ESP8266mDNS.h>

//define pin assignment and sensor config
#define DHTPIN D5
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);
Adafruit_CCS811 ccs;

//declare global variables
const char* ssid = "assist";          // wifi name
const char* password = "z1x2c3QWE";   //password
char* mqtt_server = "host_name";      //communication to rasp
unsigned long previousMillis = 0;
const long interval = 15000;
float h = 0;
float t = 0;
float co2 = 0;

//configure mqtt client
WiFiClient espClient;
PubSubClient client(espClient);

void setup() {
  Serial.begin(115200);
  pinMode(D6, OUTPUT);
  digitalWrite(D6, LOW);
  
  dht.begin();            //initialize dht
  delay(100);
  setup_wifi();           
  char copy[14];
  String ipAddress = brokerIpAddress();
  ipAddress.toCharArray(copy, 14);
  sprintf(mqtt_server, "%s",copy);
  Serial.println("Mqqt Server: ");
  Serial.println(mqtt_server);
  client.setServer(mqtt_server, 1883);    // mqtt connection to rasp
  while(!ccs.begin()){
    Serial.println("Failed to start sensor! Please check your wiring.");
   delay(1000);
  }
  
  while(!ccs.available());
  delay(2000);
}

void setup_wifi() {
  delay(10);
  // We start by connecting to a WiFi network
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);
  delay(100);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void reconnect() {
  // Loop until we're reconnected
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    // Attempt to connect
    if (client.connect("MonitoringSensorClient")) {
      Serial.println("connected");
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}

void loop() {
  if (!client.connected()) {      // reconnection mqtt
      reconnect();
    }
  client.loop();
  unsigned long currentMillis = millis();
  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;
    readTempHumid();
    readCOTwo();
    sendTemp();
    delay(2000);
    sendHumid();
    delay(2000);
    sendCOTwo();
  }
}

//read temperature and humidity from sensor
void readTempHumid(){
  h = dht.readHumidity();
  t = dht.readTemperature();
}

// read co2 value
void readCOTwo(){
  if(ccs.available()){
    if(!ccs.readData()){
      co2 = ccs.geteCO2();
      Serial.print("CO2: ");
      Serial.println(co2);
    }
  }
}

void sendTemp(){
  //send temperature to server
  char temperature[50];
  String temp = "tempe " + String(t);
  temp.toCharArray(temperature, 20);
  client.publish("icuMonitoring/data",temperature);
}

void sendHumid(){
  //send humidity to server
  char humidity[50];
  String humid = "humid " + String(h);
  humid.toCharArray(humidity, 20);
  client.publish("icuMonitoring/data",humidity);
}

void sendCOTwo(){
  //send carbon dioxide to server
  char carbondioxide[50];
  String cotwo = "cotwo " + String(co2);
  cotwo.toCharArray(carbondioxide, 20);
  client.publish("icuMonitoring/data",carbondioxide);
}

String brokerIpAddress(){
  String ipaddress ="";
   if (!MDNS.begin("ESP")) {
    Serial.println("Error setting up MDNS responder!");
  }

  Serial.println("Sending mDNS query");
  int n = MDNS.queryService("mqtt", "tcp"); // Send out query for esp tcp services
  Serial.println("mDNS query done");
  if (n == 0) {
    Serial.println("no services found");
  }
  else {
    Serial.print(n);
    Serial.println(" service(s) found");
    for (int i = 0; i < n; ++i) {
      // Print details for each service found
      Serial.print(i + 1);
      Serial.print(": ");
      Serial.print(MDNS.hostname(i));
      Serial.print(" (");
      Serial.print(MDNS.IP(i));
      Serial.print(":");
      Serial.print(MDNS.port(i));
      Serial.println(")");
      ipaddress += (MDNS.IP(i)).toString();
    }
  }
  Serial.println();

  return ipaddress;
}

