#include <Arduino.h>
const int photoresistor = 1;
void setup() {
  pinMode(photoresistor,INPUT);
  Serial.begin(9600);
}

void loop() {
  Serial.println(map(analogRead(photoresistor),0,1023,0,100));
}