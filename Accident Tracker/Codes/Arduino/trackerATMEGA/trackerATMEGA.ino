#include <TinyGPS++.h>
#include <DFRobot_sim808.h>
#include <SoftwareSerial.h>

#define PIN_TX_gps    10
#define PIN_RX_gps    11
#define PIN_TX_gsm    12
#define PIN_RX_gsm    13
#define phoneNumber "+639657326505"
#define phoneNumberOne "+639067238733"
#define sendMessage "Accident occur, please check the website to track my location!"
#define sendMessageOne "Need Police Assistance."
#define startMessage "Starting System"

unsigned long previousMillis = 0;
unsigned long previousTime = 0;
const long interval = 60000;
String latitude = "";
String longitude = "";
String message = "";
char buffer[512];
int count=0;
int sensor_pin = 7;

// The TinyGPS++ object
TinyGPSPlus gps;

// The serial connection to the GPS device
SoftwareSerial myGSM(PIN_TX_gsm, PIN_RX_gsm);
SoftwareSerial myGPS(PIN_TX_gps,PIN_RX_gps);
DFRobot_SIM808 sim808(&myGSM);

void setup(){
  Serial.begin(9600);
  myGSM.begin(9600);
  myGPS.begin(9600);
  pinMode(sensor_pin, INPUT);
  myGPS.listen();
  while(!myGPS.available()){
    Serial.println("Connecting GPS");
    delay(1000);
  }
  Serial.println("GPS Connected.");
  myGSM.listen();
  while(!sim808.init()) {
      delay(2000);
      Serial.print("GSM init error\r\n");
  }
  Serial.println("GSM Connected.");  
  while(!sim808.join(F("http.globe.com.ph"))) {
      Serial.println("GPRS join network error");
      delay(2000);
  }
  Serial.print("IP Address is ");
  Serial.println(sim808.getIPAddress());
  delay(5000);
  sim808.sendSMS(phoneNumber,startMessage);
}

void loop(){
 count += int(digitalRead(sensor_pin));
 getGPSValue();
 if (millis() - previousMillis >= interval) {
    previousMillis = millis();
    sendToCloud();
 }

 delay(10);
 if(millis()-previousTime >= 1000){
    previousTime = millis();
    Serial.print("Count value: ");
    Serial.println(count);
    if(count>=50){
      sendTextSMS();
    }
    if(count>=35){
      sim808.sendSMS(phoneNumberOne,sendMessageOne);
    }
    count=0;
  }
}

void getGPSValue(){
  myGPS.listen();
  while(myGPS.available()>0){
    gps.encode(myGPS.read());
    if (gps.location.isUpdated()){
      latitude = String(gps.location.lat(),6);
      longitude = String(gps.location.lng(),6);
    }
  }
}

void sendToCloud(){
  myGSM.listen();
  Serial.println("Sending to Cloud...");
  Serial.print("Latitude: ");
  Serial.println(latitude);
  Serial.print("Longitude: ");
  Serial.println(longitude);
  int dot = latitude.length();
  if(dot > 0){
  String toSendData = "GET https://accidenttrackerdevice.000webhostapp.com/api/tracker/create.php?latitude="+latitude+"&longitude="+longitude+"&car_shock="+count+" HTTP/1.0\r\n\r\n";
  int numbe = toSendData.length()+1;
  char http_cmd[numbe];
  toSendData.toCharArray(http_cmd,numbe);
  
  while(!sim808.connect(TCP,"accidenttrackerdevice.000webhostapp.com", 80)) {
      Serial.println("Connect error");
      delay(2000);
  }
  Serial.println("Connect accidenttrackerdevice.000webhostapp.com success");
  
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
  }else{Serial.println("Data not sent, invalid values.");}
}

void sendTextSMS(){
  Serial.println("Sending message.");
  myGSM.listen();
  delay(1000);
//  char sendMessage[250];
//  message.toCharArray(sendMessage,250);
  sim808.sendSMS(phoneNumber,sendMessage);
}

