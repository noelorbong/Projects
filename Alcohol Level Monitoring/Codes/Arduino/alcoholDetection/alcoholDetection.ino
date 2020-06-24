#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>

const char* ssid = "assist";          // change with your network
const char* password = "z1x2c3QWE";    // password
int sensorPin = A0;
int standby = D3;
int processing = D4;
int successSend = D5;
int pushButton = D6;
int buzzer = D7;
int alcohol_value;
float alcohol_level = 0.0;
float alcohol_point = 0.0;
String alcohol_point_string = "";
bool state = true;
int count = 0;

LiquidCrystal_I2C lcd(0x27, 16, 2);

byte load[8] = {
  B00000,
  B11111,
  B11111,
  B11111,
  B11111,
  B11111,
  B00000,
};

void setup () {
 
  Serial.begin(115200);
  pinMode(sensorPin, INPUT);
  pinMode(pushButton, INPUT);
  pinMode(buzzer, OUTPUT);
  pinMode(standby,OUTPUT);
  pinMode(processing,OUTPUT);
  pinMode(successSend,OUTPUT);
  lcd.begin();
  lcd.backlight();
  lcd.createChar(0, load);
  lcd.print("Starting System.");
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Connecting to...");
  lcd.setCursor(4,1);
  lcd.print(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting..");
    count++;
    if(count == 5){
      lcd.clear();
      lcd.setCursor(0,1);
      lcd.print("Wifi Unavailable");
      break;
    }
  }
  if(WiFi.status() != WL_CONNECTED) {
    Serial.print("Connected to: ");
    Serial.println(ssid);
  }
  lcd.clear();
}
 
void loop() {
  if(digitalRead(pushButton) == HIGH){
    if(state == true){
        digitalWrite(standby,LOW);
        digitalWrite(processing,HIGH);
        state = false;
        startingDetection();
        readAlcoholLevel();
        alcohol_value = 0;
    }
  }else{state = true;}
  initialState();
}

void initialState(){
  digitalWrite(standby,HIGH);
  lcd.setCursor(3,0);
  lcd.print("Standby");
  lcd.setCursor(0,1);
  lcd.print("Press Start Btn");
}

void startingDetection(){
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Reading alcohol");
  lcd.setCursor(0,1);
  lcd.print("content value.");
  delay(1000);
}

void readAlcoholLevel(){
  for(int a=0;a<1000;a++){
    int rawValue = analogRead(A0);
    if(alcohol_value<rawValue){
      alcohol_value = rawValue;
    }
    delay(10);
  }
  alcohol_point = (alcohol_value  * 0.05) / 1024;       // 0.05, set maximum value
  alcohol_point_string = String(alcohol_point, 2);
  Serial.print("Testing 0.05: ");
  Serial.println(alcohol_point_string);
  alcohol_level = (alcohol_value * 100.0) / 1024;
  Serial.println(alcohol_level);
  int row_count = (alcohol_level * 15) / 100;
  valueBarGraph(row_count);

}

void sendToDatabase(String aLevel){
  Serial.print("Alcohol level: ");
  Serial.println(aLevel);
  
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    Serial.println("Sending request...");
    http.begin("http://driveralcoholmonitoring.000webhostapp.com/api/alcohol/create.php?alcohol_level="+aLevel);
    int httpCode = http.GET();
 
    if (httpCode > 0) {
      String payload = http.getString();
      Serial.println(payload);
      digitalWrite(successSend,HIGH);
      lcd.setCursor(0,1);
      lcd.print("    Success!     ");
 
    }
    Serial.println("Session end.");
    http.end();   //Close connection
  }else{
    lcd.setCursor(0,1);
    lcd.print("Failed to send. ");
  }
}

void valueBarGraph(int n){
  lcd.clear();
  n++;
  for(int bar=0; bar < n; bar++){
    lcd.setCursor(bar,0);
    lcd.write(byte(0));
    delay(200);
  }
//  String lcdDisplay = "Content: "+ String(alcohol_level) + "%";
  String lcdDisplay = "Content: " + alcohol_point_string;
  lcd.setCursor(0,1);
  lcd.print(lcdDisplay);
  if(alcohol_level>70){
    digitalWrite(buzzer, HIGH);
  }
  digitalWrite(processing,LOW);
  delay(3000);
  digitalWrite(buzzer, LOW);
  lcd.setCursor(0,0);
  lcd.print(lcdDisplay);
  lcd.setCursor(0,1);
  lcd.print("Sending data...");
  delay(4000);
//  sendToDatabase(String(alcohol_level));
  sendToDatabase(alcohol_point_string);
  delay(4000);
  digitalWrite(successSend,LOW);
  lcd.clear();
  initialState();
}
//h ttps://driveralcoholmonitoring.000webhostapp.com/api/alcohol/create.php?alcohol_level=50

