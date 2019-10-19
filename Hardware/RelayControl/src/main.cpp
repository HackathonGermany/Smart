#include <Arduino.h>

int relays[] = {2,3,4,5,6,7,8,9};
int relay_len = 7;
void setup() {
  // put your setup code here, to run once:
  for (byte i = 0; i<relay_len;i++){
    pinMode(i,OUTPUT);
  }
}

void relay(int num, bool state){
  digitalWrite(relays[constrain(num,0,relay_len-1)],state);
}

void loop() {
  // put your main code here, to run repeatedly:
  for (int i = 0; i < relay_len;i++){
    relay(i,true);
    delay(200);
  }
  delay(1000);
  for (int i = 0; i < relay_len;i++){
    relay(i,false);
    delay(200);
  }
  delay(1000);
}