#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <SPI.h>
#include <LiquidCrystal_I2C.h>
#include <Wire.h>
#include <ESP8266mDNS.h>

#define FAN D5
#define ALARM D7

bool isFanOn = true;
bool isAlarmOn = true;
String dataName = "";
String dataValue = "";
int temperature = 0;
int co2 = 0;
LiquidCrystal_I2C lcd(0x3F, 20, 4);

// Update these with values suitable for your network.

const char* ssid = "assist";     ///icuwifi
const char* password = "z1x2c3QWE"; ///123456789
char* mqtt_server = "host_name";

WiFiClient espClient;
PubSubClient client(espClient);
String command = "";

void setup() {
  Serial.begin(115200);
  pinMode(FAN, OUTPUT);
  pinMode(ALARM, OUTPUT);
  pinMode(D6, OUTPUT);
  digitalWrite(D6, LOW);
  digitalWrite(FAN, LOW);
  digitalWrite(ALARM, LOW);
  lcd.begin();
  lcd.backlight();
  delay(1000);
  lcd.setCursor(1,0);
  lcd.print("Connecting to:");
  lcd.setCursor(5,1);
  lcd.print(String(ssid));
  setup_wifi();
  char copy[14];
  String ipAddress = brokerIpAddress();
  ipAddress.toCharArray(copy, 14);
  sprintf(mqtt_server, "%s",copy);
  Serial.println("Mqqt Server: ");
  Serial.println(mqtt_server);
  lcd.clear();
  lcd.setCursor(1,1);
  lcd.print("Humidity: ");
  lcd.setCursor(1,0);
  lcd.print("Temperature: ");
  lcd.setCursor(1,2);
  lcd.print("CO2 Value: ");
  lcd.setCursor(0,3);
  lcd.print("ICU Room Monitoring");
  client.setServer(mqtt_server, 1883);
  client.setCallback(callback);
}

void setup_wifi() {

  delay(10);
  // We start by connecting to a WiFi network
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void callback(char* topic, byte* payload, unsigned int length) {    // receiving mqtt
  Serial.print("Message arrived [");
  Serial.print(topic);
  Serial.print("] ");
  for (int i = 0; i < length; i++) {
    Serial.print((char)payload[i]);
    command += (char)payload[i];
  }
  Serial.println();
}

void reconnect() {
  // Loop until we're reconnected
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    // Attempt to connect
    if (client.connect("MonitoringComponentClient")) {
      Serial.println("connected");
      client.subscribe("icuMonitoring/data");
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}
void loop() {

  if (!client.connected()) {
    reconnect();
  }
  client.loop();
  displayData();
  command = "";
}

void displayData(){
  dataName = command.substring(0,5);
  dataValue = command.substring(6);
  if(dataName == "tempe"){
    lcd.setCursor(14,0);
    lcd.print(dataValue);
    temperature = dataValue.toInt();
  }else if(dataName == "humid"){
     lcd.setCursor(14,1);
     lcd.print(dataValue);
  }else if(dataName == "cotwo"){
     lcd.setCursor(13,2);
     lcd.print(dataValue);
     co2 = dataValue.toInt();
  }else if(dataName == "ctrfn"){
     lcd.print(dataValue);
     if(dataValue == "1"){
      digitalWrite(FAN, HIGH);
     }else{
      digitalWrite(FAN, LOW);
     }
  }else if(dataName == "ctral"){
     lcd.println(dataValue);
     if(dataValue == "1"){
      digitalWrite(ALARM, HIGH);
     }else{
      digitalWrite(ALARM, LOW);
     }
  }
}

String brokerIpAddress(){
  String ipaddress ="";
   if (!MDNS.begin("ESP")) {
    Serial.println("Error setting up MDNS responder!");
  }

  Serial.println("Sending mDNS query");
  int n = MDNS.queryService("mqtt", "tcp"); // Send out query for esp tcp services
  Serial.println("mDNS query done");
  if (n == 0) {
    Serial.println("no services found");
  }
  else {
    Serial.print(n);
    Serial.println(" service(s) found");
    for (int i = 0; i < n; ++i) {
      // Print details for each service found
      Serial.print(i + 1);
      Serial.print(": ");
      Serial.print(MDNS.hostname(i));
      Serial.print(" (");
      Serial.print(MDNS.IP(i));
      Serial.print(":");
      Serial.print(MDNS.port(i));
      Serial.println(")");
      ipaddress += (MDNS.IP(i)).toString();
    }
  }
  Serial.println();

  return ipaddress;
}

