#include "DHT.h"        // librairie du capteur de température DHT
#include <MQUnifiedsensor.h> //librairie liée au capteur MQ9
#include "Servo.h"
#include "LiquidCrystal_I2C.h"

LiquidCrystal_I2C lcd(0x27,16,2);

#define RatioMQ9CleanAir (9.6) //RS / R0 = 60 ppm (formule nécessaire au bon fonctionnement du MQ9)
#define DHTPIN A4       // detection de la température et de l'humidité
#define ldrPin A3       // detection de la luminosité
#define motorWaterPin 2 // actionneur moteur qui représente
#define motorDCPin 3    // actionneur moteur qui représente le ventilateur
#define DegEauxInPIN 4  // détecteur du niveau de l'eau dans le local
#define servmotorPIN 5  // actionneur moteur pour simuler l'ouverture/fermeture de la fenetre
#define IncendiePIN 6   // actionneur LED Rouge activation d'un sytème qui éteint l'incendie
#define LEDAQ 9         // led alerte mauvaise qualité d'air
#define LEDY 10         // led alerte degat des eaux --> coupure électricité des prises de la pièce
#define LEDR 11         // led alerte incendit
#define tempExtPIN A5   // detetion de la température extérieure

#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

//Données relatives au capteur MQ9
MQUnifiedsensor MQ9("Arduino MEGA", 5, 10, A2, "MQ-9"); // Board, Voltage_resolution, ADC_Bit_Resolution, Pin, Type
float tab[3];
bool alertMQ9[3] = {0};

//Données relatives au capteur HCHO
// Source : http://www.himix.lt/arduino/arduino-and-hcho-benzene-toluene-alcohol-sensor/
float Vol, ppm;
int sensorValue;
bool formaldehydeDetect;

Servo monServomoteur;

int ecran = 0;

int changeEcran = 999;

// Variables
int readLevel;

float reading;
float tempout;
float humidity;
float tempin;

boolean polluted = false;   // le local est pollué par des gaz
boolean hotTemp = false;    // il fait trop chaud dans le loc
boolean goodTemp = true;    // il fait bon
boolean coldTemp = false;   // il fait froid
boolean difpositive = true; // il fait plus chaud dehors que dedans
boolean ventOn = false;     // le ventilateur est allumé
boolean windowOpen = false; // la fenètre est ouverte
boolean doorLocked = false; // la porte est vérouillée
boolean alerteUser = false; // une alerte est envoyé à l'utilisateur
boolean isHumid = false;    // le seuil d'humidité est atteint
// boolean flashLED = false;

const long interval = 250;
unsigned long previousMillis = 0;
int count = 0;
String gazName = "GPL";

void setup()
{
  Serial.begin(9600);
  dht.begin();
  pinMode(DHTPIN, INPUT);
  pinMode(ldrPin, INPUT);
  pinMode(motorWaterPin, OUTPUT);
  pinMode(motorDCPin, OUTPUT);
  pinMode(DegEauxInPIN, INPUT);
  pinMode(servmotorPIN, OUTPUT);
  pinMode(IncendiePIN, OUTPUT);
  pinMode(LEDAQ, OUTPUT);
  pinMode(LEDY, OUTPUT);
  pinMode(LEDR, OUTPUT);
  pinMode(tempExtPIN, INPUT);

  int error = MQ9Setup();

  monServomoteur.attach(servmotorPIN);


  lcd.init();
  lcd.backlight();
}

void loop()
{

  // récupère la donnée du capteur de température extérieur
  reading = analogRead(tempExtPIN);
  //tempout = get_temp_out(reading);
  tempout = 20;

  // recupère les infos du DHT11 pour la température et l'humidité
  humidity = dht.readHumidity();
  tempin = dht.readTemperature();
  Serial.print("temperature interieure");
  Serial.println(tempin);

  difpositive = is_temp_positive(tempin, tempout);

  set_temp_flags(tempin, &hotTemp, &goodTemp, &coldTemp);

  //récupère les mesures des gaz détectés par le MQ9 
  MQ9mesure(tab);

  //Activation du système de détection dans le MQ9
  MQ9valeurseuil(tab, alertMQ9);
 

  //Affichage des mesures réalisées par le MQ9 - vérification interne
  /*Serial.println("Mesures");
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
  Serial.println("");*/

  //récupère les mesures des gaz détectés par le HCHO
  sensorValue=analogRead(A6);
  Vol=sensorValue*4.95/1023;
  ppm = map(Vol, 0, 4.95, 1, 50); // Concentration Range: 1~50 ppm 
  
  //Affichage des mesures réalisées par le HCHO - vérification interne
  /*Serial.print("Sensor Value: ");
  Serial.print(sensorValue);
  Serial.print("   ppm: ");
  Serial.print(ppm);*/

   //Activation du système de détection dans le HCHO
   HCHOAlertDetection(sensorValue, &formaldehydeDetect);


  //Si l'un des capteurs détecte une quantité anormale de gaz --> le local est pollué il faut aérer !   
   if (alertMQ9[0] == 1 || alertMQ9[1] == 1 || alertMQ9[2] == 1 || formaldehydeDetect == 1){
    polluted = true;
   }

  //Vérification de la qualité de l'air dans le local - vérification interne
   Serial.print("\npollution: ");
   Serial.println(polluted);

/*
   Serial.print (tab[0]);
      Serial.print (tab[1]);
         Serial.print (tab[2]);

  


    lcd.print("GPL ");
    lcd.print(tab[0]);

    lcd.print(" CH4 ");
    lcd.print(tab[1]);

    lcd.print(" CO ");
    lcd.print(tab[2]);

    lcd.setCursor(1,1);
    lcd.print("Temperature: ");
    lcd.print(tempin);


     for (int positionCounter = 0; positionCounter < 20; positionCounter++) {

      lcd.scrollDisplayLeft();
      // pause courte
      delay(500);
    }



    for (int positionCounter = 0; positionCounter < 20; positionCounter++) {

      lcd.scrollDisplayRight();
      // courte pause
      delay(500);
    }

    */


  // Module qualité d'air

  // si taux monoxide ou propane ou méthane, alerte utilisateur, ventilation + fenètre ouverte
  if (polluted) // regarder quand l'air est polluer sur le MQ9
  {
    if (!windowOpen)
    {
      // window opens
      open_window(monServomoteur, &windowOpen);
    }
    if (!ventOn)
    {
      // ventilo switch on
      switch_vent_on(tempout, &ventOn);
    }
    // alerter l'utilisateur
    alerte_user(&alerteUser);
  }

  // si la température est trop élevée à l'intérieur
  if (hotTemp)
  {
    // allumer la ventilation si elle ne l'est pas déjà
    if (!ventOn)
    {
      // ventilo switched on
      // ventOn = true;
      // +ventilo à 100%
      switch_vent_on(tempout, &ventOn);
    }
    if (difpositive)
    { // s'il fait moins chaud dehors
      if (!windowOpen)
      {
        // window opens
        open_window(monServomoteur, &windowOpen);
      }
    }
    else if (!difpositive)
    { // s'il fait plus chaud dehors
      if (windowOpen)
      {
        // window closes
        close_window(&windowOpen);
      }
    }
  }

  // else if température faible à l'intérieur
  if (coldTemp)
  {
    // éteindre la ventilation si elle ne l'est pas déjà
    if (ventOn)
    {
      // ventilo switched off
      switch_vent_off(&ventOn);
    }
    if (difpositive)
    { // s'il fait moins chaud dehors
      if (windowOpen)
      {
        // window closes
        close_window(&windowOpen);
      }
    }
    else if (!difpositive)
    {
      if (!windowOpen)
      {
        // window opens
        open_window(monServomoteur, &windowOpen);
      }
    }
  }

  if (humidity > 80)
  {
    isHumid = true;
    open_window(monServomoteur, &windowOpen);
  }

  // else il fait bon et l'air est pur
  else
  {
    if (!ventOn)
    {
      // ventilo switch on
      switch_vent_on(tempExtPIN, &ventOn);
    }
  }

  // Partie dégâts des eaux - source : https://www.instructables.com/Water-Level-Alarm-Using-Arduino/

  readLevel = digitalRead(DegEauxInPIN); //DegEauxInPIN et LEDY agissent ensemble comme un interrupteur
  if (readLevel == LOW) //Le circuit est fermé
  {
    digitalWrite(LEDY, HIGH);
    analogWrite(motorDCPin, 255); // activation de la pompe au maximum
  }
  else
  {
    digitalWrite(LEDY, LOW);
    analogWrite(motorDCPin, 0); // désactivation de la pompe
  }

  
  Serial.println(ventOn);




  changeEcran ++;
  Serial.print("changeEcran: ");
  Serial.print(changeEcran);

  Serial.print("Ecran: ");
  Serial.print(ecran);
  if (changeEcran > 100){
    ecran++;
    changeEcran = 0;
    AffichEcran(lcd, ecran, tab, tempin, humidity, sensorValue);
    if (ecran == 3){
      ecran = 0;
    }
  }
  
}

void switch_vent_on(int temperature, boolean *ventOn)
{
  float Ftemp = (temperature - 15) * (255 / 15);
  int Pw = min(255, max(0, Ftemp));
  analogWrite(motorDCPin, Pw);
  *ventOn = true;
}
void switch_vent_off(boolean *ventOn)
{
  analogWrite(motorDCPin, 0);
  *ventOn = false;
}

void open_window(Servo monservomoteur, boolean *windowOpen)
{
  int angle = 0;
  monServomoteur.write(180);
      // scan from 0 to 180 degrees
    /*for(angle = 0; angle < 180; angle++) {
        monservomoteur.write(angle);
        delay(15);
    }
    
    // now scan back from 180 to 0 degrees
    for(angle = 180; angle > 0; angle--) {
        monservomoteur.write(angle);
        delay(15);
    }*/
  *windowOpen = true;
}
void close_window(boolean *windowOpen)
{
  monServomoteur.write(0);
  *windowOpen = false;
}

void alerte_user(boolean *alerteUser)
{
  // rajouter un envoie de message à la rasPi jusqu'à l'utilisateur
  digitalWrite(LEDAQ, HIGH);
  *alerteUser = true;
}
void finish_user_alerte(boolean *alerteUser)
{
  digitalWrite(LEDAQ, LOW);
  *alerteUser = false;
}

boolean is_temp_positive(float tempin, float tempout)
{
  float diftemp = tempin - tempout;
  return (0 < diftemp);
}

float get_temp_out(float reading)
{
  float voltage = reading * (5000 / 1024.0);
  float tempout = (voltage - 500) / 10;
  return tempout;
}

void set_temp_flags(float tempin, boolean *hotTemp, boolean *goodTemp, boolean *coldTemp)
{
  if (tempin > 24)
  {
    *hotTemp = true;
    *goodTemp = false;
    *coldTemp = false;
  }
  else if (tempin < 18)
  {
    *hotTemp = false;
    *goodTemp = false;
    *coldTemp = true;
  }
  else
  {
    *hotTemp = false;
    *goodTemp = true;
    *coldTemp = false;
  }
}

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
    Serial.print("ALERT ! Excès de GPL (LPG) - Risque d'incendie !");
  }
  if (tab[1] > 9990){// Source : https://www.heatingandprocess.com/methane-gas-detection/ LEL=5% -> 50000 ppm. Comme le module détecte max 10000 alors on met un peu moins -> 9990 ppm
    reactiontab[1] = 1;
    Serial.print("ALERT ! Excès de Méthane (CH4) - Risque d'incendie !");
  }
  if (tab[2] > 35){// Source : https://cdn.shopify.com/s/files/1/0406/7681/files/Carbon-Monoxide-Levels-Chart.jpg?v=1565211200
    reactiontab[2] = 1;
    Serial.print("ALERT ! Excès de monoxyde de carbone (CO) - Risque de suffocation !");
  }
  return reactiontab;

}

void HCHOAlertDetection (int sensorValue, bool* formaldehydeDetect){
  if (sensorValue > 500) {
      Serial.println("Alert HCHO");
      *formaldehydeDetect = true;
    }
    else {
      *formaldehydeDetect = false;
    }
}

void AffichEcran(LiquidCrystal_I2C lcd, int ecran, float* tab, int tempin, float humidity, float sensorValue){
  
  if(ecran == 3){
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("GPL : ");
    lcd.print(tab[0]);
    lcd.print(" ppm");

    lcd.setCursor(0,1);
    lcd.print("CH4 : ");
    lcd.print(tab[1]);
    lcd.print(" ppm");
  }

  else if (ecran == 1){
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("CO : ");
    lcd.print(tab[2]);
    lcd.print(" ppm");

    lcd.setCursor(0,1);
    lcd.print("Temp : ");
    lcd.print(tempin);
    lcd.print(" C");
    
  }
  else if (ecran == 2){
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("humidite : ");
    lcd.print(humidity);
    lcd.print(" %");

    lcd.setCursor(0,1);
    lcd.print("HCHO : ");
    lcd.print(sensorValue);
    lcd.print(" ppm");
  }

  
}
