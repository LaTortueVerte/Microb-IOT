#include <MQUnifiedsensor.h>
#define RatioMQ9CleanAir (9.6) //RS / R0 = 60 ppm 
MQUnifiedsensor MQ9("Arduino MEGA", 5, 10, A2, "MQ-9"); // Board, Voltage_resolution, ADC_Bit_Resolution, Pin, Type

int MQ9Setup(){
  MQ9.setRegressionMethod(1); //_PPM =  a*ratio^b
  MQ9.init(); 
  float calcR0 = 0;
  for(int i = 1; i<=10; i ++)
  {
    MQ9.update(); // Update data, the arduino will read the voltage from the analog pin
    calcR0 += MQ9.calibrate(RatioMQ9CleanAir);
  }
  MQ9.setR0(calcR0/10);
  
  int error = 0;
  if(isinf(calcR0)) {
    //Serial.println("Warning: Conection issue, R0 is infinite (Open circuit detected)");
    error = -1;
  }
  if(calcR0 == 0){
    //Serial.println("Warning: Conection issue found, R0 is zero (Analog pin shorts to ground)");
    error = -2;
  }

  return error;
}

void setup() {
  int error = MQ9Setup();
  Serial.begin(9600);
}

void MQ9mesure(float* tab){

  MQ9.update();
  
  MQ9.setA(1000.5); MQ9.setB(-2.186); // Configure the equation to to calculate LPG concentration
  tab[0] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  MQ9.setA(4269.6); MQ9.setB(-2.648); // Configure the equation to to calculate CH4 concentration
  tab[1] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  MQ9.setA(599.65); MQ9.setB(-2.244); // Configure the equation to to calculate CO concentration
  tab[2] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup
}

bool* MQ9valeurseuil(float* tab, bool* reactiontab){

  if (tab[0] > 500){// Source : http://umpir.ump.edu.my/id/eprint/8365/1/Design_and_Development_of_Gas_Leakage_Monitoring_System.pdf
    reactiontab[0] = 1;
  }
  if (tab[1] > 9990){// Source : https://www.heatingandprocess.com/methane-gas-detection/ LEL=5% -> 50000 ppm. Comme le module détecte max 10000 alors on met un peu moins -> 9990 ppm
    reactiontab[1] = 1;
  }
  if (tab[2] > 35){// Source : https://cdn.shopify.com/s/files/1/0406/7681/files/Carbon-Monoxide-Levels-Chart.jpg?v=1565211200
    reactiontab[2] = 1;
  }
  return reactiontab;
}


float tab[3];
bool alertMQ9[3] = {0};

void loop() {

  MQ9mesure(tab);

  MQ9valeurseuil(tab, alertMQ9);

  // PRINT
  /*
  Serial.println("Mesures");
  for(int i=0; i<3; i++){
    Serial.print("   |   ");
    Serial.print(tab[i]);
  }
  Serial.println("");

  Serial.println("Alert");
  for(int i=0; i<3; i++){
    Serial.print("   |   ");
    Serial.print(alertMQ9[i]);
  }
  Serial.println("");
  */
  // DELAY
  
  delay(1000);
}