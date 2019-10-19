#include <Arduino.h>
#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
  #include "time.h"
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif
#include <Wire.h>
// Replace with your network credentials
const char* ssid     = "EULE-Gast";
const char* password = "@EULE_Zukunft!";

// REPLACE with your Domain name and URL path or IP address with path
const char* serverName = "http://192.168.1.179/API/post-esp-data.php";
const char* ntpServer = "0.de.pool.ntp.org";
const long  gmtOffset_sec = 3600;
const int   daylightOffset_sec = 3600;
long int UNIX = 0; 
// Keep this API Key value to be compatible with the PHP code provided in the project page. 
// If you change the apiKeyValue value, the PHP file /post-esp-data.php also needs to have the same key 
String apiKeyValue = "tPmAT5Ab3j7F9";

#define SEALEVELPRESSURE_HPA (1013.25)
void printLocalTime()
{
  struct tm timeinfo;
  if(!getLocalTime(&timeinfo)){
    Serial.println("Failed to obtain time");
    return;
    }
time_t now;
time(&now);
UNIX = now;
}

void setup() {
  Serial.begin(115200);
  
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
  printLocalTime();
  // (you can also pass in a Wire library object like &Wire2)
 
}

void loop() {
  printLocalTime();
  //Check WiFi connection status
  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
    
    // Your Domain name with URL path or IP address with path
    http.begin(serverName);
    
    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    String httpRequestData = "api_key=" + apiKeyValue + "&strom=" + String("1")
                           + "&spannung=" + String("2") + "&watt=" + String("3")
                           + "&lichtstaerke=" + String("4") + "&temperatur=" + String(5) + "&luftfeuchtigkeit=" + String(6) 
                           + "&status=" + String(7) + "&time=" + String(UNIX) + "";           
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
    
    // You can comment the httpRequestData variable above
    // then, use the httpRequestData variable below (for testing purposes without the BME280 sensor)
    

    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);
     

        
    if (httpResponseCode>0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 30 seconds
  delay(5000);  
}
