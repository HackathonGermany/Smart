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
Value = analogRead(35);
Value = constrain(Value,0,2900);
Value = map(Value,0,2900,0,1000);
Serial.println(Value);
delay(150);
}