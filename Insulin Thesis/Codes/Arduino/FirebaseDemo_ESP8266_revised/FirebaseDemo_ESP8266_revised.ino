#include <SoftwareSerial.h>
#include <ESP8266WiFi.h>
#include <FirebaseArduino.h>
#include "DHT.h"

// Set these to run example.
#define FIREBASE_HOST "insulin-room.firebaseio.com"
#define FIREBASE_AUTH "DTOqh9EgYLeFXCJuMaTK2zPjwgwKNwv2QAoPoRzl"
#define WIFI_SSID "wifi"
#define WIFI_PASSWORD "88888888"
#define DHTPIN D1     // what digital pin the DHT22 is conected to
#define DHTTYPE DHT22   // there are multiple kinds of DHT sensors
#define PIN_TX D7
#define PIN_RX D8

int n = 0;
int count = 0;
String messageToSend = "";
int buzzer = D5;

unsigned long previousTimeSystem = 0;
unsigned long sendInterval = 15000;
bool isSend = true;
bool isSendStable = true;

DHT dht(DHTPIN, DHTTYPE);
SoftwareSerial mySerial(PIN_TX,PIN_RX);


typedef struct {
  float temp, humi, heat;
} SensorData;

void setup() {
  Serial.begin(115200);
  mySerial.begin(115200);
  pinMode(buzzer, OUTPUT);
  //initialze gsm
  while(!mySerial.available()){
      mySerial.println("AT");
      delay(1000);
      Serial.println("connecting....");
  }
  Serial.println("GSM init success");
  // connect to wifi.
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.print("connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
    count++;
    if(count == 10){
      break;
    }
  }
  Serial.println();
  if(WiFi.status() != WL_CONNECTED){
    Serial.println("Wifi Unavailable.");
  }else{
    Serial.print("connected: ");
    Serial.println(WiFi.localIP());
    Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH); 
  }
  

  Serial.println("Device Started");
  Serial.println("-------------------------------------");
  Serial.println("Running DHT!");
  Serial.println("-------------------------------------");
}


void loop() {
  
 SensorData sensorData = read_sensor();
 
 if (sensorData.temp > 0){
    sendToFire(sensorData);
 }

 if(sensorData.temp >= 25  || sensorData.temp <= 15){
    isSendStable = true;
    digitalWrite(buzzer, HIGH);
    if(isSend == true){
      messageToSend = "Temperature reached " + String(sensorData.temp) + " Degree Celcius. Please adjust Accordingly.";
      isSend = false;
      sendMessage();
    } 
  }else{
    isSend = true;
    digitalWrite(buzzer, LOW);
    if(isSendStable == true){
      messageToSend = "Temperature stabilized. Current Temperature is " + String(sensorData.temp) + " Degree Celcius.";
      isSendStable = false;
      sendMessage();
    }
  }
}

void sendMessage()
{
  Serial.println("Sending message...");
  mySerial.println("AT+CMGF=1");
  delay(1000);
  mySerial.println("AT+CMGS=\"+639179309392\"\r");
  delay(1000);
  mySerial.println(messageToSend);
  delay(100);
  mySerial.println((char)26);
  delay(1000);
}



void sendToFire(SensorData data){
  
  unsigned long currentTimeSystem = millis();
  if(currentTimeSystem - previousTimeSystem >= sendInterval){
    previousTimeSystem = currentTimeSystem;
    
    Serial.print("Humidity: ");
    Serial.print(data.humi);
    Serial.print(" %\t");
    Serial.print("Temperature: ");
    Serial.print(data.temp);
    Serial.print(" *C ");
    Serial.print("Heat index: ");
    Serial.println(data.heat);
    
    DynamicJsonBuffer jsonBuffer;
    ;
  
    if(isnan(data.temp)) {
      Serial.println("Failed to read from DHT sensor!");
      return;
    }
  
    // Push to Firebase
    JsonObject& temperatureObject = jsonBuffer.createObject();
  //  JsonObject& humid = temperatureObject.createNestedObject("humi");
  //  JsonObject& heatIn = temperatureObject.createNestedObject("heat");
    JsonObject& tempTime = temperatureObject.createNestedObject("timestamp");
    temperatureObject["temp"] = data.temp;
    temperatureObject["humi"] = data.humi;
    temperatureObject["heat"] = data.heat;
    tempTime[".sv"] = "timestamp";
    Firebase.push("temperature", temperatureObject);
    // handle error
    if (Firebase.failed()) {
        Serial.print("pushing /temperature failed:");
        Serial.println(Firebase.error());
        return;
    }
    
    Serial.println("Push success");
  }
}


SensorData read_sensor() {

    SensorData sensorData;
    // Reading temperature or humidity takes about 250 milliseconds!
    // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)
    float humi = dht.readHumidity();
    // Read temperature as Celsius (the default)
    float temp = dht.readTemperature();
    // Read temperature as Fahrenheit (isFahrenheit = true)
    float f = dht.readTemperature(true);

    // Check if any reads failed and exit early (to try again).
    if (isnan(humi) || isnan(temp) || isnan(f)) {
      Serial.println("Failed to read from DHT sensor!");
      return {0, 0, 0};
    }

    // Compute heat index in Fahrenheit (the default)
    float hif = dht.computeHeatIndex(f, humi);
    // Compute heat index in Celsius (isFahreheit = false)
    float hic = dht.computeHeatIndex(temp, humi, false);

//    Serial.print("Humidity: ");
//    Serial.print(humi);
//    Serial.print(" %\t");
//    Serial.print("Temperature: ");
//    Serial.print(temp);
//    Serial.print(" *C ");
//    Serial.print(f);
//    Serial.print(" *F\t");
//    Serial.print("Heat index: ");
//    Serial.print(hic);
//    Serial.print(" *C ");
//    Serial.print(hif);
//    Serial.println(" *F");

    sensorData.temp = temp;
    sensorData.humi = humi;
    sensorData.heat = hic;
    
  return sensorData;
}

