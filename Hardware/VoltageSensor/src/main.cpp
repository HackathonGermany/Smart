#include <Arduino.h>

const int voltageSensor = 0;
void setup() {
  pinMode(voltageSensor,INPUT);
  Serial.begin(9600);
}

void loop() {
  long var = analogRead(voltageSensor);
  var = map(var,0,1023,0,20);
  Serial.println(String(var)+" V");
}