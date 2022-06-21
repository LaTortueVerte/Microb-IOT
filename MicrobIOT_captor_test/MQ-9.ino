#include <MQUnifiedsensor.h>
#define         Board                   ("Arduino MEGA")
#define         Pin                     (A2)  //Analog input 4 of your arduino
#define         Type                    ("MQ-9") //MQ9
#define         Voltage_Resolution      (5)
#define         ADC_Bit_Resolution      (10) // For arduino UNO/MEGA/NANO
#define         RatioMQ9CleanAir        (9.6) //RS / R0 = 60 ppm 
MQUnifiedsensor MQ9(Board, Voltage_Resolution, ADC_Bit_Resolution, Pin, Type);

void setup() {
  Serial.begin(9600);
  MQ9.setRegressionMethod(1); //_PPM =  a*ratio^b
  MQ9.init(); 
  Serial.print("Calibrating please wait.");
  float calcR0 = 0;
  for(int i = 1; i<=10; i ++)
  {
    MQ9.update(); // Update data, the arduino will read the voltage from the analog pin
    calcR0 += MQ9.calibrate(RatioMQ9CleanAir);
    Serial.print(".");
  }
  MQ9.setR0(calcR0/10);
  Serial.println("  done!.");
  
  if(isinf(calcR0)) {Serial.println("Warning: Conection issue, R0 is infinite (Open circuit detected)"); while(1);}
  if(calcR0 == 0){Serial.println("Warning: Conection issue found, R0 is zero (Analog pin shorts to ground)"); while(1);}
  /*****************************  MQ CAlibration ********************************************/ 
  Serial.println("** Values from MQ-9 ****");
  Serial.println("|    LPG   |  CH4 |   CO  |");
}

void loop() {
  MQ9.update();
  /*
  Exponential regression:
  GAS     | a      | b
  LPG     | 1000.5 | -2.186
  CH4     | 4269.6 | -2.648
  CO      | 599.65 | -2.244
  */
  
  MQ9.setA(1000.5); MQ9.setB(-2.186); // Configure the equation to to calculate LPG concentration
  float LPG = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  MQ9.setA(4269.6); MQ9.setB(-2.648); // Configure the equation to to calculate CH4 concentration
  float CH4 = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  MQ9.setA(599.65); MQ9.setB(-2.244); // Configure the equation to to calculate CO concentration
  float CO = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  Serial.print("|    "); Serial.print(LPG);
  Serial.print("    |    "); Serial.print(CH4);
  Serial.print("    |    "); Serial.print(CO); 
  Serial.println("    |");

  if (LPG > 500){// Source : http://umpir.ump.edu.my/id/eprint/8365/1/Design_and_Development_of_Gas_Leakage_Monitoring_System.pdf
    Serial.println("Alert LGP");
  }
  if (CH4 > 9990){// Source : https://www.heatingandprocess.com/methane-gas-detection/ LEL=5% -> 50000 ppm
    Serial.println("Alert CH4");// Comme le module détecte max 10000 alors on met un peu moins -> 9990 ppm
  }
  if (CO > 35){// Source : https://cdn.shopify.com/s/files/1/0406/7681/files/Carbon-Monoxide-Levels-Chart.jpg?v=1565211200
    Serial.println("Alert CO");
  }

  delay(500); //Sampling frequency
}