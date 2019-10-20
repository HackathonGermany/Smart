#include <Arduino.h>

#include <Arduino.h>

const int relays[] = {17,5,18,19};
const int relay_len = 4;
void setup() {
  for (byte i = 0; i<relay_len;i++){
    pinMode(relays[i],OUTPUT);
  }
}

void relay(int num, bool state){
  digitalWrite(relays[constrain(num,0,relay_len-1)],state);
}

void loop() {
  //example code
  // for (int i = 0; i < relay_len;i++){
  //   relay(i,true);
  //   delay(200);
  // }
  // delay(1000);
  // for (int i = relay_len-1; i >= 0;i--){
  //   relay(i,false);
  //   delay(200);
  // }
  // delay(1000);
}