unsigned long previousMillis = 0;
const long interval = 1000;
char dataBits; 
String receivedData;
String latitude="15.045563";
String longitude="120.67267";
String serial_no = "imeds0001";
void setup()
{
	Serial.begin(115200);
	Serial1.begin(115200);
  pinMode(4, OUTPUT);
  pinMode(5, OUTPUT);
  pinMode(8,OUTPUT);
  digitalWrite(5, HIGH); 
  digitalWrite(4, LOW); 
  digitalWrite(8, HIGH); 
  delay(3000);       
  digitalWrite(8, LOW);
  Serial.println("A7 Power ON!");
  delay(3000);
//  std::numeric_limits<float>::digits10;
Serial1.println("AT+GPS=0");
}

void loop()
{
//  if(Serial1.available()){
//    while(Serial1.available()){
//      dataBits = Serial1.read();
//      receivedData += dataBits;
//    }
//  //  Serial.print(receivedData);
//  }
// unsigned long currentMillis = millis();
// if (currentMillis - previousMillis >= interval) {
//    previousMillis = currentMillis;
//    getGPSValue();
//    delay(3000);
//    receivedData = "";
// }

sendLocationData();
 
}

void sendLocationData(){
  Serial.println("Sending Coordinates.");
  Serial1.println("AT");
  delay(2000);
  Serial1.println("AT+CPIN?");
  delay(2000);
  Serial1.println("AT+CREG?");
  delay(2000);
  Serial1.println("AT+CGATT?");
  delay(2000);
  Serial1.println("AT+CIPMUX=0");
  delay(2000);
  Serial1.println("AT+CSTT=\"http.globe.com.ph\",\"\",\"\"");
  delay(2000);
  Serial1.println("AT+CIICR");
  delay(2000);
  Serial1.println("AT+CIFSR");
  delay(2000);
  Serial1.println("AT+CIPSTART=\"TCP\",imeds-hau.esy.es,80");
  delay(4000);
  Serial1.println("AT+CIPSEND");
  delay(2000);
  String location = "GET http://imeds-hau.esy.es/api/v1/storelocation/"+latitude+"/"+longitude+"/"+serial_no;
  Serial1.println(location);
  delay(2000);
  Serial1.println((char)26);
  delay(2000);
  Serial1.println("AT+CIPSHUT");
}

void getGPSValue(){
  Serial.println("Getting GPS Location");
  Serial1.println("AT+GPS=1");
  delay(2000);
  Serial1.println("AT+LOCATION=2");
  delay(2000);
  int findLocation = receivedData.indexOf("LOCATION");
  if(findLocation > 0){
    String data = receivedData.substring(findLocation+11);
    int findComma = data.indexOf(",");
    if(findComma > 0){
      Serial.print("Comma value: ");
      Serial.println(findComma);
      String latitudeValue = data.substring(3,findComma);
      latitude = latitudeValue;
      Serial.print("Latitude: ");
      Serial.println(latitude);
      String longitudeValue = data.substring(findComma+1);
      longitude = longitudeValue;
      Serial.print("Longitude: ");
      Serial.println(longitude);
      findComma = 0;
     // sendLocationData();
    } else {Serial.println("Couldn't find GPS Location!");}
  }
}

