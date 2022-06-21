// Source : http://www.himix.lt/arduino/arduino-and-hcho-benzene-toluene-alcohol-sensor/
float Vol, ppm;
int sensorValue;

void setup()
{
    Serial.begin(9600);
}
void loop()
{
    sensorValue=analogRead(A4);
    Vol=sensorValue*4.95/1023;
    ppm = map(Vol, 0, 4.95, 1, 50); // Concentration Range: 1~50 ppm 
    Serial.print("Sensor Value: ");
    Serial.print(sensorValue);
    Serial.print("   ppm: ");
    Serial.print(ppm);
    
    if (sensorValue > 500) {
      Serial.println("Alert HCHO");
    }
    else {
      Serial.println();
    }
    
    delay(1000);
}