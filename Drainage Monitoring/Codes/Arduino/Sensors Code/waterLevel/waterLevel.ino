const int trigPin = 9;                  // assign Digital I/O pin 9 to trigPin or the transmitter
const int echoPin = 10;              // assign Digital I/O pin 10 to echoPinor the receiver
 
long duration;                           // use variable duration for as to save the received data from the sensor
int distance;                              //  use variable to save the calculated distance from the received data
void setup() {
 
pinMode(trigPin, OUTPUT);     // configure trigPin as output
pinMode(echoPin, INPUT);       // configure echoPin as input
Serial.begin(9600);
 
}
void loop() {
 
digitalWrite(trigPin, LOW);      // initialize first the sensor by setting it low
delay(50);
 
digitalWrite(trigPin, HIGH);     // activate the transmitter of the sensor
delay(50);                               
digitalWrite(trigPin, LOW);      // turns off the transmitter
 
duration = pulseIn(echoPin, HIGH);      // set the receiver on and enables the pulses from the
                                                            // transmitter to pass in the receiver
distance= duration*0.034/2;                  //calculate the distance measurement in cm
 
Serial.print("Distance: ");                      // display the distance in your Serial Monitor
Serial.println(distance);                         // and its value
 
}
