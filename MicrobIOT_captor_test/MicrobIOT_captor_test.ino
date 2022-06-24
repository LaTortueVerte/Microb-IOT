#include "DHT.h"             // librairie du capteur de température DHT
#include <MQUnifiedsensor.h> //librairie liée au capteur MQ9

#define RatioMQ9CleanAir (9.6) // RS / R0 = 60 ppm (formule nécessaire au bon fonctionnement du MQ9)
#define DHTPIN A4              // detection de la température et de l'humidité
#define ldrPin A3              // detection de la luminosité
#define motorWaterPin 2        // actionneur moteur qui représente
#define motorDCPin 3           // actionneur moteur qui représente le ventilateur
#define DegEauxInPIN 4         // détecteur du niveau de l'eau dans le local
#define servmotorPIN 5         // actionneur moteur pour simuler l'ouverture/fermeture de la fenetre
#define IncendiePIN 6          // actionneur LED Rouge activation d'un sytème qui éteint l'incendie
#define LEDGM 9                // led alerte mauvaise qualité d'air
#define LEDY 10                // led alerte degat des eaux --> coupure électricité des prises de la pièce
#define LEDR 11                // led alerte incendit
#define tempExtPIN A5          // detetion de la température extérieure

#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

// Données relatives au capteur MQ9
MQUnifiedsensor MQ9("Arduino MEGA", 5, 10, A2, "MQ-9"); // Board, Voltage_resolution, ADC_Bit_Resolution, Pin, Type
float tab[3];
bool alertMQ9[3] = {0};

// Données relatives au capteur HCHO
//  Source : http://www.himix.lt/arduino/arduino-and-hcho-benzene-toluene-alcohol-sensor/
float Vol, ppm;
int sensorValue;
bool formaldehydeDetect;

// monServomoteur.attach(servmotorPIN);

// Variables

// UART variables
boolean window_state = false;
int ventilation_power = 0;
double min_temp_ventilation = 18.00;
double max_temp_ventilation = 24.00;
boolean pump_state = false;        // la pompe est allumée
boolean air_quality_module = true; // si le module de qualité d'air existe
boolean water_module = true;
boolean gas_module_alert = true;

// Other variables
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
  pinMode(LEDGM, OUTPUT);
  pinMode(LEDY, OUTPUT);
  pinMode(LEDR, OUTPUT);
  pinMode(tempExtPIN, INPUT);

  int error = MQ9Setup();
}

void loop()
{

  // récupère la donnée du capteur de température extérieur
  reading = analogRead(tempExtPIN);
  tempout = get_temp_out(reading);

  // recupère les infos du DHT11 pour la température et l'humidité
  humidity = dht.readHumidity();
  tempin = dht.readTemperature();

  difpositive = is_temp_positive(tempin, tempout);

  set_temp_flags(tempin, &hotTemp, &goodTemp, &coldTemp);

  // récupère les mesures des gaz détectés par le MQ9
  MQ9mesure(tab);

  // Activation du système de détection dans le MQ9
  MQ9valeurseuil(tab, alertMQ9);
  delay(1000);

  // Affichage des mesures réalisées par le MQ9 - vérification interne
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

  // récupère les mesures des gaz détectés par le HCHO
  sensorValue = analogRead(A6);
  Vol = sensorValue * 4.95 / 1023;
  ppm = map(Vol, 0, 4.95, 1, 50); // Concentration Range: 1~50 ppm

  // Affichage des mesures réalisées par le HCHO - vérification interne
  /*Serial.print("Sensor Value: ");
  Serial.print(sensorValue);
  Serial.print("   ppm: ");
  Serial.print(ppm);*/

  // Activation du système de détection dans le HCHO
  HCHOAlertDetection(sensorValue, &formaldehydeDetect);
  delay(1000);

  // Si l'un des capteurs détecte une quantité anormale de gaz --> le local est pollué il faut aérer !
  if (alertMQ9[0] == 1 || alertMQ9[1] == 1 || alertMQ9[2] == 1 || formaldehydeDetect == 1)
  {
    polluted = true;
  }

  // Vérification de la qualité de l'air dans le local - vérification interne
  /*Serial.print("\npollution: ");
  Serial.print(polluted);*/
  // si taux monoxide ou propane ou méthane, alerte utilisateur, ventilation + fenètre ouverte
  if (polluted) // regarder quand l'air est polluer sur le MQ9
  {
    if (!windowOpen)
    {
      // window opens
      open_window(&windowOpen);
    }
    if (!ventOn)
    {
      // ventilo switch on
      switch_vent_on(&ventOn);
    }
    if (gas_module_alert)
    {
      // alerter l'utilisateur
      alerte_user(&alerteUser);
    }
  }
}
// Module qualité d'air
else if (!air_quality_module)
{
  power = ventilation_power * 2.55; // to set the temperature in percentages
  analogWrite(motorDCPin, ventilation_power * 2.55);
  if (window_state)
  {
    Servo.write(90);
  }
  else
  {
    Servo.write(0);
  }
}
else
{
  // si la température est trop élevée à l'intérieur
  if (hotTemp)
  {
    // allumer la ventilation si elle ne l'est pas déjà
    if (!ventOn)
    {
      // ventilo switched on
      // ventOn = true;
      // +ventilo à 100%
      switch_vent_on(&ventOn);
    }
    if (difpositive)
    { // s'il fait moins chaud dehors
      if (!windowOpen)
      {
        // window opens
        open_window(&windowOpen);
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
  else if (coldTemp)
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
        open_window(&windowOpen);
      }
    }
  }

  else if (humidity > 80)
  {
    isHumid = true;
    open_window(&windowOpen);
  }

  // else il fait bon et l'air est pur
  else
  {
    if (!ventOn)
    {
      // ventilo switch on
      switch_vent_on(&ventOn);
    }
  }
}

/*
// Test la luminosité

int ldrStatus = analogRead(ldrPin);
if (ldrStatus <= 50)
{
  Serial.print("Ils fait sombre, allume la lumière ! luminosité : ");
  Serial.println(ldrStatus);
}
else
{
  Serial.print("Ils fait claire, eteint la lumière ! luminosité : ");
  Serial.println(ldrStatus);
}*/

// Partie dégâts des eaux - source : https://www.instructables.com/Water-Level-Alarm-Using-Arduino/
if (!water_module)
{
}
else
{
  readLevel = digitalRead(DegEauxInPIN); // DegEauxInPIN et LEDY agissent ensemble comme un interrupteur
  if (readLevel == LOW)                  // Le circuit est fermé
  {
    digitalWrite(LEDY, HIGH);
    analogWrite(motorDCPin, 255); // activation de la pompe au maximum
  }
  else
  {
    digitalWrite(LEDY, LOW);
    analogWrite(motorDCPin, 0); // désactivation de la pompe
  }
}
}

void switch_vent_on(boolean *ventOn, double max_temp_ventilation, double min_temp_ventilation)
{
  double temp_gap = max_temp_ventilation - min_temp_ventilation;
  float Ftemp = (temp_gap)*255 / temp_gap;
  int Pw = min(255, max(0, Ftemp));
  analogWrite(motorDCPin, Pw);
  *ventOn = true;
}
void switch_vent_off(boolean *ventOn)
{
  analogWrite(motorDCPin, 0);
  *ventOn = false;
}

void open_window(boolean *windowOpen)
{
  Servo.write(90);
  *windowOpen = true;
}
void close_window(boolean *windowOpen)
{
  Servo.write(0);
  *windowOpen = false;
}

void open_door(boolean *doorLocked)
{
  Servo.write(90);
  *doorLocked = false;
}
void close_door(boolean *doorLocked)
{
  Servo.write(0);
  *doorLocked = true;
}

void alerte_user(boolean *alerteUser)
{
  // rajouter un envoie de message à la rasPi jusqu'à l'utilisateur
  digitalWrite(LEDGM, HIGH);
  *alerteUser = true;
}
void finish_user_alerte(boolean *alerteUser)
{
  digitalWrite(LEDGM, LOW);
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
  if (tempin > max_temp_ventilation)
  {
    *hotTemp = true;
    *goodTemp = false;
    *coldTemp = false;
  }
  else if (tempin < min_temp_ventilation)
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

int MQ9Setup()
{
  MQ9.setRegressionMethod(1); //_PPM =  a*ratio^b
  MQ9.init();
  float calcR0 = 0;
  for (int i = 1; i <= 10; i++)
  {
    MQ9.update(); // Update data, the arduino will read the voltage from the analog pin
    calcR0 += MQ9.calibrate(RatioMQ9CleanAir);
  }
  MQ9.setR0(calcR0 / 10);

  int error = 0;
  if (isinf(calcR0))
  {
    // Serial.println("Warning: Conection issue, R0 is infinite (Open circuit detected)");
    error = -1;
  }
  if (calcR0 == 0)
  {
    // Serial.println("Warning: Conection issue found, R0 is zero (Analog pin shorts to ground)");
    error = -2;
  }

  return error;
}

void MQ9mesure(float *tab)
{

  MQ9.update();

  MQ9.setA(1000.5);
  MQ9.setB(-2.186);          // Configure the equation to to calculate LPG concentration
  tab[0] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  MQ9.setA(4269.6);
  MQ9.setB(-2.648);          // Configure the equation to to calculate CH4 concentration
  tab[1] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  MQ9.setA(599.65);
  MQ9.setB(-2.244);          // Configure the equation to to calculate CO concentration
  tab[2] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup
}

bool *MQ9valeurseuil(float *tab, bool *reactiontab)
{

  if (tab[0] > 500)
  { // Source : http://umpir.ump.edu.my/id/eprint/8365/1/Design_and_Development_of_Gas_Leakage_Monitoring_System.pdf
    reactiontab[0] = 1;
    Serial.print("ALERT ! Excès de GPL (LPG) - Risque d'incendie !");
  }
  if (tab[1] > 9990)
  { // Source : https://www.heatingandprocess.com/methane-gas-detection/ LEL=5% -> 50000 ppm. Comme le module détecte max 10000 alors on met un peu moins -> 9990 ppm
    reactiontab[1] = 1;
    Serial.print("ALERT ! Excès de Méthane (CH4) - Risque d'incendie !");
  }
  if (tab[2] > 35)
  { // Source : https://cdn.shopify.com/s/files/1/0406/7681/files/Carbon-Monoxide-Levels-Chart.jpg?v=1565211200
    reactiontab[2] = 1;
    Serial.print("ALERT ! Excès de monoxyde de carbone (CO) - Risque de suffocation !");
  }
  return reactiontab;
}

void HCHOAlertDetection(int sensorValue, bool *formaldehydeDetect)
{
  if (sensorValue > 500)
  {
    Serial.println("Alert HCHO");
    *formaldehydeDetect = true;
  }
  else
  {
    *formaldehydeDetect = false;
  }
}
