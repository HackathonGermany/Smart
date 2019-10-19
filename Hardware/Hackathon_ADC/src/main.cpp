#include <Arduino.h>
int Value;
void setup() {
  // put your setup code here, to run once:
pinMode(A0,INPUT);
Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
Value = analogRead(A0);
Value = constrain(Value,5,250);
Value = map(Value,5,250,0,470);
Serial.println(Value);
}