#include <WiFi.h>
#include <PubSubClient.h>

bool state = true;
int outletOne = 32;
int outletTwo = 33;

// Update these with values suitable for your network.

const char* ssid = "automatedHome";
const char* password = "autopass";
const char* mqtt_server = "192.168.0.102";

WiFiClient espClient;
PubSubClient client(espClient);
long lastMsg = 0;
char msg[50];
int value = 0;
String command = "";

void setup() {
  Serial.begin(115200);
  pinMode(outletOne, OUTPUT);
  pinMode(outletTwo, OUTPUT);
  setup_wifi();
  client.setServer(mqtt_server, 1883);
  client.setCallback(callback);
  digitalWrite(outletOne, LOW);
  digitalWrite(outletTwo, LOW);
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

void callback(char* topic, byte* payload, unsigned int length) {
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
    if (client.connect("ESP8266ClientOutlet")) {
      Serial.println("connected");
      client.subscribe("automation/switch");
      digitalWrite(outletOne, LOW);
      client.publish("automation/switch","3hctiws off");
      Serial.println("Outlet One switched off");
      digitalWrite(outletTwo, LOW);
      client.publish("automation/switch","4hctiws off");
      Serial.println("Outlet Two switched off");
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
  
  if(command == "3hctiws on"){
    digitalWrite(outletOne, HIGH);
  }
  if(command == "3hctiws off"){
    digitalWrite(outletOne, LOW);
  }
  if(command == "4hctiws on"){
    digitalWrite(outletTwo, HIGH);
  }
  if(command == "4hctiws off"){
    digitalWrite(outletTwo, LOW);
  } 
  command = "";
  delay(1000);
}
