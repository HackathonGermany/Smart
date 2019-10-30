#include <Arduino.h>

float Value;
void setup() {
  // put your setup code here, to run once:
analogReadResolution(12);
analogSetAttenuation(ADC_11db);
Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
Value = analogRead(34);
Value = constrain(Value,0.0,3550.0);
Value = map(Value,0.0,3550.0,0.0,12.0);
Serial.println(Value);
delay(150);
}