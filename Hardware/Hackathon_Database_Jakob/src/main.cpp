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

struct DHT_return{
  long temperature;
  long humidity;
};

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
const int relay_len = 4;
const int Relays[] = {2, 3, 4, 5};
const char unic_rep[] = {30, 31};
char StateArray[relay_len];
int RelayValues[relay_len];

String datum;
String formattedDate;
String dayStamp;
String timeStamp;

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
long current_read() {
  return map(constrain(analogRead(35), 0, 2900), 0, 2900, 0, 1000);
}
long voltage_read() {
  return map(constrain(analogRead(34), 0.0, 3550.0), 0.0, 3550.0, 0.0, 12.0);
}
long calc_power(long voltage, long current) {
  return voltage * (current / 1000);
}
long ldr_read() { return map(analogRead(32), 0, 4096, 0, 101); }

DHT_return dht_read(){
  DHT_return return_val;
  return_val.humidity = dht.readHumidity();
  return_val.temperature = dht.readTemperature();
  return return_val;
}
String date() {
  timeClient.update();
  return timeClient.getFormattedTime();
}
void updateStateArray() {
  for (byte i = 0; i < relay_len; i++) {
    StateArray[i] = unic_rep[RelayValues[i]];
  }
}
void updateRelays() {
  for (byte i = 0; i < relay_len; i++)
    digitalWrite(Relays[i], RelayValues[i]);
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
  Serial.println("done");
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
  updateRelays();
}

void loop() {
  printLocalTime();
  ADC_READ();
  Voltage();
  Leistung();
  LDR();
  DATUM();
  Status();
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Your Domain name with URL path or IP address with path
    http.begin(serverName);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String httpRequestData =
        "api_key=" + apiKeyValue + "&strom=" + String(c) +
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