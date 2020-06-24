#include <IRremoteESP8266.h>
#include <IRsend.h>

#define IR_SEND_PIN D4
#define IR_SEND_PIN_TWO D3

IRsend irsend(IR_SEND_PIN);
IRsend irsendtwo(IR_SEND_PIN_TWO);

int upTemp = D6;
int downTemp = D5;
bool upTempState = false;
bool downTempState = false;

void setup()
{
 irsend.begin();
 irsendtwo.begin();
 pinMode(upTemp, INPUT);
 pinMode(downTemp, INPUT);
  Serial.begin(115200);
}
 
void loop()
{
  if(digitalRead(upTemp) == HIGH) {  
 
    if(upTempState == false) {
     irsend.sendSony(0xa90, 12);
     irsendtwo.sendSony(0xa90, 12);
     Serial.println("Pressed! Up temperature.");
     upTempState = true;
    } 
  } else { upTempState = false; }
  
  if(digitalRead(downTemp) == HIGH) {  
 
    if(downTempState == false) {
     irsend.sendSony(0xa80, 12);
     irsendtwo.sendSony(0xa80, 12);
     Serial.println("Pressed! Down temperature");
     downTempState = true;
    } 
  } else { downTempState = false; }
}
