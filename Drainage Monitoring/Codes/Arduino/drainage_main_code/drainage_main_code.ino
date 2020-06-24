#include <DFRobot_sim808.h>
#include <SoftwareSerial.h>
#include "DHT.h"
#include <Wire.h>

#define DHTPIN 8
#define DHTTYPE DHT22
#define phoneNumber "09164570748"

DFRobot_SIM808 sim808(&Serial);
DHT dht(DHTPIN, DHTTYPE);

char buffer[512];
unsigned long lastSystemTime = 0;
unsigned long lastDistanceTime = 0;
unsigned long interval = 60000;
unsigned long oldTime = 0;
//////distance
const int trigPin = 9;
const int echoPin = 10;
long duration;
int distanceCm;
//////water flow
byte sensorInterrupt = 0;
byte sensorPin       = 2;
float calibrationFactor = 4.5;
volatile byte pulseCount = 0;
float flowRate = 0.0;
String message = "";
String temperature = "";
String humidity = "";
String water_level = "";
String water_flow = "";

void setup(){
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  
  Serial.begin(9600);
  
  while(!sim808.init()) {
      delay(1000);
      Serial.print("Sim808 init error\r\n");
  }
  delay(3000);  
  while(!sim808.join(F("http.globe.com.ph"))) {
      Serial.println("Sim808 join network error");
      delay(2000);
  }
  Serial.print("IP Address is ");
  Serial.println(sim808.getIPAddress());
  dht.begin();
  attachInterrupt(sensorInterrupt, pulseCounter, FALLING);
}

void loop(){
  
  if(millis() - lastDistanceTime >= 900){
    lastDistanceTime = millis();
    getWaterFlow();
    getWaterLevel();
  }
  unsigned long currentSystemTime = millis();
  if(currentSystemTime - lastSystemTime >= interval){
    lastSystemTime = currentSystemTime;
    getTempHumid();
    sendToCloud(temperature,humidity,water_level,water_flow);
  }
}

void getWaterFlow(){
      detachInterrupt(sensorInterrupt);
      flowRate = ((1000.0 / (millis() - oldTime)) * pulseCount) / calibrationFactor;
      oldTime = millis();
      Serial.print("Flow rate: ");
      Serial.print(flowRate);
      Serial.println("L/min");
      water_flow = String(flowRate);
      pulseCount = 0;
      attachInterrupt(sensorInterrupt, pulseCounter, FALLING);
}

void getTempHumid(){
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  if (isnan(h) || isnan(t)) {
    Serial.println("Failed to read from DHT sensor!");
    return;
  }else{
    temperature = String(t);
    humidity = String(h);
  }
}

void getWaterLevel(){
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  duration = pulseIn(echoPin, HIGH);
  distanceCm= duration*0.034/2;
  if(distanceCm>100){
    distanceCm = 100;
  }
  switch(distanceCm){
    case 50:
      message = "Water is 50 cm high.";
      sendMessage();
      break;
    case 40:
      message = "Water is 60 cm high.";
      sendMessage();
      break;
    case 30:
      message = "Water is 70 cm high.";
      sendMessage();
      break;
    case 20:
      message = "Water is 80 cm high.";
      sendMessage();
      break;
    case 10:
      message = "Water is 90 cm high.";
      sendMessage();
      break;
    case 5:
      message = "Warning water level is too high!";
      sendMessage();
      break;
  }
  int sendDistance = 100 - distanceCm;
  water_level = String(sendDistance);
  Serial.print("Water Level: ");
  Serial.print(water_level);
  Serial.println("%");
}

void sendMessage(){
  char sendMessage[250];
  message.toCharArray(sendMessage,250);
  sim808.sendSMS(phoneNumber,sendMessage);
}

void sendToCloud(String temp,String humid,String wlevel, String wflow){
  Serial.print("Temp: ");
  Serial.print(temp);
  Serial.print(" Humid: ");
  Serial.print(humid);
  Serial.print(" W_level: ");
  Serial.print(wlevel);
  Serial.print(" W_flow: ");
  Serial.println(wflow);
  String toSendData = "GET https://drainagemonitoring.000webhostapp.com/drainage/create.php?temperature="+ temp +"&humidity="+ humid +"&water_level="+ wlevel +"&water_flow="+ wflow +" HTTP/1.0\r\n\r\n";
  int numbe = toSendData.length()+1;
  char http_cmd[numbe];
  toSendData.toCharArray(http_cmd,numbe);
  
  while(!sim808.connect(TCP,"drainagemonitoring.000webhostapp.com", 80)) {
      Serial.println("Connect error");
      delay(2000);
  }
  Serial.println("Connect drainagemonitoring.000webhostapp.com success");
  
  Serial.println("waiting to fetch...");
  sim808.send(http_cmd, sizeof(http_cmd)-1);
  while (true) {
      int ret = sim808.recv(buffer, sizeof(buffer)-1);
      if (ret <= 0){
          Serial.println("fetch over...");
          break; 
      }
      buffer[ret] = '\0';
      Serial.print("Recv: ");
      Serial.print(ret);
      Serial.print(" bytes: ");
      Serial.println(buffer);
      break;
  }
  sim808.close();
}

void pulseCounter(){
  pulseCount++;
}

