#include <Arduino.h>

int Value;
void setup() {
  // put your setup code here, to run once:
analogReadResolution(12);
analogSetAttenuation(ADC_11db);
Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
Value = analogRead(13);
Value = constrain(Value,0,2440);
Value = map(Value,0,2440,0,910);
Serial.println(Value);
delay(150);
}