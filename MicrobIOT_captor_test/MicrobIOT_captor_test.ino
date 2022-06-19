#include "DHT.h"
#define DHTPIN A4     // Digital pin connected to the DHT sensor
const int ldrPin = A3;
const int motorDCPin = 3;
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(9600);
  dht.begin();
  pinMode(ldrPin, INPUT);
  pinMode(motorDCPin, OUTPUT);
}

void loop() {
  delay(2000);
  //digitalWrite(motorDCPin, HIGH);
  //delay(2000);
  //digitalWrite(motorDCPin, LOW);
  //Read humidity and temperature
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  //Print humidity and temperature
  Serial.print(F("Humidity: "));
  Serial.print(h);
  Serial.print(F("%  Temperature: "));
  Serial.print(t);
  Serial.println(F("°C "));

  //Action of the motor if the temperature is too high
  /*if (t < 15) {
     analogWrite(motorDCPin, 0);
  }
  else if (t >= 15 && t < 20){
    analogWrite(motorDCPin, 70);
  }
  else if (t >=20 && t < 25){
    analogWrite(motorDCPin, 150);
  }
  else{
     analogWrite(motorDCPin, 255);
  }*/
  float Ftemp = (t-15)*(255/15);
  int Pw = min(255, max(0, Ftemp));
  analogWrite(motorDCPin, Pw);
  

  //Test if it's bright or not
  int ldrStatus = analogRead(ldrPin);
  if (ldrStatus <= 50) {
    Serial.print("Its DARK, Turn on the LED : ");
    Serial.println(ldrStatus);
  } 
  else {
    Serial.print("Its BRIGHT, Turn off the LED : ");
    Serial.println(ldrStatus);
  }

  

  


  
}
