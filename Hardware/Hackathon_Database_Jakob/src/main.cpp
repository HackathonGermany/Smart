#include <Arduino.h>
#ifdef ESP32
#include "DHT.h"
#include "time.h"
#include <HTTPClient.h>
#include <NTPClient.h>
#include <WiFi.h>
#include <WiFiUdp.h>

#else
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiClient.h>

#endif
#include <Wire.h>
WiFiUDP ntpUDP;

// Replace with your network credentials
const char *ssid = "EULE-Gast";
const char *password = "@EULE_Zukunft!";
NTPClient timeClient(ntpUDP, "0.de.pool.ntp.org", 7200, 2500);
// REPLACE with your Domain name and URL path or IP address with path
const char *serverName = "http://192.168.1.179/API/post-esp-data.php";
const char *ntpServer = "0.de.pool.ntp.org";
const long gmtOffset_sec = 3600;
const int daylightOffset_sec = 3600;
long int UNIX = 0;
float CURRENT = 0;
float VOLTAGE = 0;
float POWER = 0;
float INTENSITY = 0;
String datum;
String formattedDate;
String dayStamp;
String timeStamp;
int S_1 = 0;
int S_2 = 0;
int S_3 = 0;
int S_4 = 0;
char StateArray[4];
// Keep this API Key value to be compatible with the PHP code provided in the
// project page. If you change the apiKeyValue value, the PHP file
// /post-esp-data.php also needs to have the same key
String apiKeyValue = "tPmAT5Ab3j7F9";
#define DHTTYPE DHT11
#define DHTPIN 14
void printLocalTime() {
  struct tm timeinfo;
  if (!getLocalTime(&timeinfo)) {
    Serial.println("Failed to obtain time");
    return;
  }
  time_t now;
  time(&now);
  UNIX = now;
}
void ADC_READ() {
  int Value;
  Value = analogRead(35);
  Value = constrain(Value, 0, 2900);
  Value = map(Value, 0, 2900, 0, 1000);
  CURRENT = Value;
}
void Voltage() {
  int Value;
  Value = analogRead(34);
  Value = constrain(Value, 0.0, 3550.0);
  Value = map(Value, 0.0, 3550.0, 0.0, 12.0);
  VOLTAGE = Value;
}
long Leistung(long voltage, long current) {
  return voltage * (current / 1000);
}
long LDR() {
  return map(analogRead(32), 0, 4096, 0, 101);
}
String date() {
  timeClient.update();
  return timeClient.getFormattedTime();
}
void Status() {
  if (S_1 == 1) {
    StateArray[0] = '1';
  }
  if (S_1 == 0) {
    StateArray[0] = '0';
  }
  if (S_2 == 1) {
    StateArray[1] = '1';
  }
  if (S_2 == 0) {
    StateArray[1] = '0';
  }
  if (S_3 == 1) {
    StateArray[2] = '1';
  }
  if (S_3 == 0) {
    StateArray[2] = '0';
  }
  if (S_4 == 1) {
    StateArray[3] = '1';
  }
  if (S_4 == 0) {
    StateArray[3] = '0';
  }
  StateArray[4] = 0;
}
void R1(bool state) {
  S_1 = state;
  if (state == 1) {
    digitalWrite(17, LOW);
  } else {
    digitalWrite(17, HIGH);
  }
}
void R2(bool state) {
  S_2 = state;
  if (state == 1) {
    digitalWrite(5, LOW);
  } else {
    digitalWrite(5, HIGH);
  }
}
void R3(bool state) {
  S_3 = state;
  if (state == 1) {
    digitalWrite(18, LOW);
  } else {
    digitalWrite(18, HIGH);
  }
}
void R4(bool state) {
  S_4 = state;
  if (state == 1) {
    digitalWrite(19, LOW);
  } else {
    digitalWrite(19, HIGH);
  }
}
DHT dht(DHTPIN, DHTTYPE);
void setup() {
  Serial.begin(115200);
  analogReadResolution(12);
  analogSetAttenuation(ADC_11db);
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(100);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
  printLocalTime();
  // (you can also pass in a Wire library object like &Wire2)
  dht.begin();
  timeClient.begin();
  pinMode(17, OUTPUT);
  pinMode(5, OUTPUT);
  pinMode(18, OUTPUT);
  pinMode(19, OUTPUT);
  R1(0);
  R2(0);
  R3(0);
  R4(0);
}

void loop() {
  printLocalTime();
  ADC_READ();
  Voltage();
  Leistung();
  LDR();
  DATUM();
  Status();
  float h = dht.readHumidity();
  // Read temperature as Celsius (the default)
  float t = dht.readTemperature();
  // Check WiFi connection status
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Your Domain name with URL path or IP address with path
    http.begin(serverName);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String httpRequestData =
        "api_key=" + apiKeyValue + "&strom=" + String(CURRENT) +
        "&spannung=" + String(VOLTAGE) + "&watt=" + String(POWER) +
        "&lichtstaerke=" + String(INTENSITY) + "&temperatur=" + String(t) +
        "&luftfeuchtigkeit=" + String(h) + "&status=" + String(StateArray) +
        "&time=" + String(UNIX) + "&datum=" + String(datum) + "";
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);

    // You can comment the httpRequestData variable above
    // then, use the httpRequestData variable below (for testing purposes
    // without the BME280 sensor)

    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    } else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }
  // Send an HTTP POST request every 30 seconds
  delay(5000);
}