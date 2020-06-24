#include <boarddefs.h>
#include <IRremote.h>
#include <IRremoteInt.h>
#include <ir_Lego_PF_BitStreamEncoder.h>
 
 
int RECV_PIN = 11;
int buzzer_pin = 12;
int ledOne = 7;
int ledTwo = 6;
String data = "";

IRrecv irrecv(RECV_PIN);
decode_results results;
 
void setup()
{
  pinMode(ledOne, OUTPUT);
  pinMode(ledTwo, OUTPUT);
  pinMode(buzzer_pin,OUTPUT);
  Serial.begin(115200);
  irrecv.enableIRIn();
}
 
void loop(){
  
  if (irrecv.decode(&results)){
    
     Serial.println(results.value, HEX);
     data = String(results.value,HEX);
     data.toUpperCase();
     decodeIR();
     irrecv.resume();
    }
}

void decodeIR(){
  
  if(data == "A90"){
      Serial.println("Up command");
      digitalWrite(ledOne, HIGH);
      digitalWrite(buzzer_pin, HIGH);
      delay(2000);
      digitalWrite(ledOne, LOW);
      digitalWrite(buzzer_pin, LOW);
  }
  if(data == "A80"){
      Serial.println("Down command");
      digitalWrite(ledTwo, HIGH);
      digitalWrite(buzzer_pin, HIGH);
      delay(2000);
      digitalWrite(ledTwo, LOW);
      digitalWrite(buzzer_pin, LOW);
  }
}

