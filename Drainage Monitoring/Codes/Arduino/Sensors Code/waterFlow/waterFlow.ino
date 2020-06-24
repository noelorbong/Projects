byte sensorInterrupt = 0;  // 0 = digital pin 2
byte sensorPin       = 2;
float calibrationFactor = 4.5;
volatile byte pulseCount = 0;
float flowRate = 0.0;
unsigned int flowMilliLitres = 0;
unsigned long totalMilliLitres = 0;

unsigned long oldTime = 0;

void setup() {
  // put your setup code here, to run once:
  Serial.begin(38400);
  attachInterrupt(sensorInterrupt, pulseCounter, FALLING);
}

void loop() {
  // put your main code here, to run repeatedly:
  if((millis() - oldTime) > 1000){
    detachInterrupt(sensorInterrupt);
    flowRate = ((1000.0 / (millis() - oldTime)) * pulseCount) / calibrationFactor;
    oldTime = millis();
    Serial.print("Flow rate: ");
    Serial.print(flowRate);
    Serial.println("L/min");
    pulseCount = 0;
    attachInterrupt(sensorInterrupt, pulseCounter, FALLING);
  }
}

void pulseCounter(){
  pulseCount++;
}
