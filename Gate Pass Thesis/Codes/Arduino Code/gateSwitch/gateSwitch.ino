#include <Servo.h>
#include <Wire.h>

//char command[10];
char bits;
String command = "";
char InGateClosed[20] = "InGateClosed";
char OutGateClosed[20] = "OutGateClosed";
bool isInCarPresent = false;
bool isInCarHasPassed = false;
bool isOutCarPresent = false;
bool isOutCarHasPassed = false;
long durationOne;
long durationTwo;
int ultraDistanceOne;
int ultraDistanceTwo;

// Ultrasonic pin assignment
const int trigPinOne = 2;
const int echoPinOne = 3;

const int trigPinTwo = 6;
const int echoPinTwo = 7;

// servo pin assignment and configuration
int servoPin = 9;
int servoAngle = 0;

int manualPin = 10;
int manualPinState = LOW;
bool isOpenOnce = true;

Servo servo;



void setup() {
  Serial.begin(9600);
  pinMode(trigPinOne, OUTPUT);
  pinMode(echoPinOne, INPUT);
  pinMode(trigPinTwo, OUTPUT);
  pinMode(echoPinTwo, INPUT);
  pinMode(manualPin, INPUT);
  
  servo.attach(servoPin);
  servo.write(servoAngle);
  Serial.write("GateClosed");
}

void loop() {
  manualPinState = digitalRead(manualPin);

  if (manualPinState == HIGH){
      if(isOpenOnce)
      {
        openGate();
        isOpenOnce = false;
       }
      
   }else{
      if(!isOpenOnce){
        closeGate();
         isOpenOnce = true;
       }   
    }
  
  if(Serial.available()){
    while(Serial.available()){
      delay(10);
      bits = Serial.read();
      command +=bits;
    }
    command.trim();
   //Serial.println(command);
  }
  
  if(command == "inopen"){
    openGate();
    calculateDistanceTwo();
    isInCarHasPassed = false;
    Serial.write(InGateClosed);
    //Serial.println(InGateClosed);
  }else if(command == "outopen"){
    openGate();
    calculateDistanceOne();
    isOutCarHasPassed = false;
    Serial.write(OutGateClosed);
    //Serial.println(OutGateClosed);
  }
  command = "";
}

void calculateDistanceOne(){
  while(isOutCarHasPassed == false){
    digitalWrite(trigPinOne, LOW);
    delayMicroseconds(2);
    digitalWrite(trigPinOne, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPinOne, LOW);
  
    durationOne = pulseIn(echoPinOne, HIGH);
    ultraDistanceOne = durationOne*0.0133/2;  // inches
    //Serial.print("Distance One: ");
    //Serial.println(ultraDistanceOne);
    if(ultraDistanceOne <= 10){
      //Serial.println("Car detected.");
      isOutCarPresent = true;
    }
    if(ultraDistanceOne > 10 && isOutCarPresent == true){
      //Serial.println("Car has passed. countdown started.");
      isOutCarPresent = false;
      delay(1000);
      closeGate();
      isOutCarHasPassed = true;
    }
  }
}

void calculateDistanceTwo(){
  while(isInCarHasPassed == false){
    digitalWrite(trigPinTwo, LOW);
    delayMicroseconds(2);
    digitalWrite(trigPinTwo, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPinTwo, LOW);
  
    durationTwo = pulseIn(echoPinTwo, HIGH);
    ultraDistanceTwo = durationTwo*0.0133/2;  // inches
    //Serial.print("Distance Two: ");
    //Serial.println(ultraDistanceTwo);
    if(ultraDistanceTwo <= 10){
      //Serial.println("Car detected.");
      isInCarPresent = true;
    }
    if(ultraDistanceTwo > 10 && isInCarPresent == true){
      //Serial.println("Car has passed. countdown started.");
      isInCarPresent = false;
      delay(1000);
      closeGate();
      isInCarHasPassed = true;
    }
  }
}

void openGate(){
  //Serial.println("Opening gate...");
  for(servoAngle = 0; servoAngle <90; servoAngle++){
    servo.write(servoAngle);
    delay(50);
  }
}

void closeGate(){
  //Serial.println("Closing gate...");
  for(servoAngle = 90; servoAngle >0; servoAngle--){
    servo.write(servoAngle);
    delay(50);
  }
}

